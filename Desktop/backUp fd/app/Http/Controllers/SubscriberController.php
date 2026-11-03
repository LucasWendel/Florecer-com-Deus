<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SubscriberController extends Controller
{
    public function login()
    {
        if (session('subscriber_email')) {
            return redirect()->route('assinante.area');
        }
        return view('subscriber.login');
    }

    public function checkEmail(Request $request)
    {
        $request->validate(
            ['email' => ['required', 'email']],
            ['email.required' => 'Informe seu e-mail.', 'email.email' => 'Informe um e-mail válido.']
        );

        $email = strtolower(trim($request->email));
        $order = Order::where('customer_email', $email)->where('status', 'paid')->latest()->first();

        if (! $order) {
            return back()->withErrors(['email' => 'E-mail não encontrado. Verifique se o pagamento foi confirmado ou se o endereço está correto.'])->withInput();
        }

        if (empty($order->subscriber_password)) {
            session(['subscriber_setup_token' => $order->access_token]);
            return redirect()->route('assinante.definir-senha');
        }

        session(['subscriber_email_check' => $email]);
        return redirect()->route('assinante.senha');
    }

    public function showPassword()
    {
        if (! session('subscriber_email_check')) {
            return redirect()->route('assinante.login');
        }
        return view('subscriber.password', ['email' => session('subscriber_email_check')]);
    }

    public function loginPassword(Request $request)
    {
        if (! session('subscriber_email_check')) {
            return redirect()->route('assinante.login');
        }

        $request->validate(['password' => ['required']], ['password.required' => 'Informe sua senha.']);

        $email = session('subscriber_email_check');
        $order = Order::where('customer_email', $email)->where('status', 'paid')->latest()->first();

        if (! $order || ! Hash::check($request->password, $order->subscriber_password)) {
            return back()->withErrors(['password' => 'Senha incorreta. Tente novamente.']);
        }

        session()->forget('subscriber_email_check');
        session(['subscriber_email' => $email, 'subscriber_order_id' => $order->id]);
        return redirect()->route('assinante.area');
    }

    public function showSetPassword()
    {
        if (! session('subscriber_setup_token')) {
            return redirect()->route('assinante.login');
        }
        $order = Order::where('access_token', session('subscriber_setup_token'))->first();
        if (! $order) {
            session()->forget('subscriber_setup_token');
            return redirect()->route('assinante.login')->withErrors(['email' => 'Link inválido. Inicie novamente.']);
        }
        return view('subscriber.set-password', ['name' => $order->customer_name]);
    }

    public function setPassword(Request $request)
    {
        if (! session('subscriber_setup_token')) {
            return redirect()->route('assinante.login');
        }

        $request->validate([
            'password'              => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['required'],
        ], [
            'password.required'  => 'Defina uma senha.',
            'password.min'       => 'A senha deve ter pelo menos 6 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
        ]);

        $token = session('subscriber_setup_token');
        $order = Order::where('access_token', $token)->first();

        if (! $order) {
            session()->forget('subscriber_setup_token');
            return redirect()->route('assinante.login')->withErrors(['email' => 'Link inválido. Inicie novamente.']);
        }

        $order->subscriber_password = Hash::make($request->password);
        $order->password_set_at = now();
        $order->save();

        session()->forget('subscriber_setup_token');
        session(['subscriber_email' => $order->customer_email, 'subscriber_order_id' => $order->id]);
        return redirect()->route('assinante.area');
    }

    public function area()
    {
        if (! session('subscriber_email')) {
            return redirect()->route('assinante.login');
        }

        $order = Order::where('customer_email', session('subscriber_email'))
            ->where('status', 'paid')->latest()->first();

        if (! $order) {
            session()->forget(['subscriber_email', 'subscriber_order_id']);
            return redirect()->route('assinante.login');
        }

        $whatsappLink  = config('services.whatsapp.group_link');
        $submission    = FormSubmission::where('order_id', $order->id)->first();
        return view('subscriber.area', compact('order', 'whatsappLink', 'submission'));
    }

    public function formulario()
    {
        if (! session('subscriber_email')) {
            return redirect()->route('assinante.login');
        }

        $order = Order::where('customer_email', session('subscriber_email'))
            ->where('status', 'paid')->latest()->first();

        if (! $order) {
            return redirect()->route('assinante.login');
        }

        $submission = FormSubmission::where('order_id', $order->id)->first();
        return view('subscriber.formulario', compact('order', 'submission'));
    }

    public function enviarFormulario(Request $request)
    {
        if (! session('subscriber_email')) {
            return redirect()->route('assinante.login');
        }

        $order = Order::where('customer_email', session('subscriber_email'))
            ->where('status', 'paid')->latest()->first();

        if (! $order) {
            return redirect()->route('assinante.login');
        }

        if (FormSubmission::where('order_id', $order->id)->exists()) {
            return redirect()->route('assinante.formulario')->with('already_sent', true);
        }

        $validated = $request->validate([
            'full_name'        => ['required', 'string', 'max:255'],
            'published_name'   => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'max:255'],
            'phone'            => ['required', 'string', 'max:50'],
            'country_birth'    => ['required', 'string', 'max:100'],
            'country_current'  => ['required', 'string', 'max:100'],
            'profession'       => ['required', 'string', 'max:255'],
            'mini_bio'         => ['required', 'string'],
            'birthday'         => ['required', 'string', 'max:20'],
            'testimony_title'  => ['nullable', 'string', 'max:255'],
            'testimony_file'   => ['required', 'file', 'max:10240'],
            'photo_file'       => ['required', 'file', 'max:10240', 'mimes:jpg,jpeg,png,webp'],
            'language_pref'    => ['required', 'string', 'in:en,pt,es'],
            'social_auth'      => ['required', 'string', 'in:yes,no'],
            'how_found'        => ['required', 'string', 'max:100'],
            'faith_aspects'    => ['nullable', 'array'],
            'faith_aspects.*'  => ['string', 'max:100'],
            'future_events'    => ['nullable', 'string', 'max:20'],
            'enthusiasm'       => ['nullable', 'integer', 'min:1', 'max:5'],
        ], [
            'full_name.required'       => 'Informe o nome completo.',
            'published_name.required'  => 'Informe o nome a ser publicado.',
            'email.required'           => 'Informe o e-mail.',
            'phone.required'           => 'Informe o telefone.',
            'country_birth.required'   => 'Informe o país de nascimento.',
            'country_current.required' => 'Informe o país atual.',
            'profession.required'      => 'Informe a profissão ou vocação.',
            'mini_bio.required'        => 'Escreva sua mini bio.',
            'birthday.required'        => 'Informe a data de aniversário.',
            'testimony_file.required'  => 'Envie o arquivo do testemunho.',
            'photo_file.required'      => 'Envie a foto.',
            'photo_file.mimes'         => 'A foto deve ser JPG, JPEG, PNG ou WEBP.',
            'language_pref.required'   => 'Selecione o idioma preferido.',
            'social_auth.required'     => 'Responda sobre a autorização de redes sociais.',
            'how_found.required'       => 'Informe como soube do projeto.',
        ]);

        $dir = public_path('uploads/formulario/' . $order->id);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $testimonyPath = null;
        if ($request->hasFile('testimony_file')) {
            $f    = $request->file('testimony_file');
            $name = 'testemunho_' . time() . '.' . $f->getClientOriginalExtension();
            $f->move($dir, $name);
            $testimonyPath = 'uploads/formulario/' . $order->id . '/' . $name;
        }

        $photoPath = null;
        if ($request->hasFile('photo_file')) {
            $f    = $request->file('photo_file');
            $name = 'foto_' . time() . '.' . $f->getClientOriginalExtension();
            $f->move($dir, $name);
            $photoPath = 'uploads/formulario/' . $order->id . '/' . $name;
        }

        FormSubmission::create([
            'order_id'         => $order->id,
            'full_name'        => $validated['full_name'],
            'published_name'   => $validated['published_name'],
            'email'            => $validated['email'],
            'phone'            => $validated['phone'],
            'country_birth'    => $validated['country_birth'],
            'country_current'  => $validated['country_current'],
            'profession'       => $validated['profession'],
            'mini_bio'         => $validated['mini_bio'],
            'birthday'         => $validated['birthday'],
            'testimony_title'  => $validated['testimony_title'] ?? null,
            'testimony_file'   => $testimonyPath,
            'photo_file'       => $photoPath,
            'language_pref'    => $validated['language_pref'],
            'social_auth'      => $validated['social_auth'],
            'how_found'        => $validated['how_found'],
            'faith_aspects'    => implode(', ', $validated['faith_aspects'] ?? []),
            'future_events'    => $validated['future_events'] ?? null,
            'enthusiasm'       => $validated['enthusiasm'] ?? null,
        ]);

        return redirect()->route('assinante.formulario')->with('success', true);
    }

    public function logout()
    {
        session()->forget(['subscriber_email', 'subscriber_order_id', 'subscriber_email_check', 'subscriber_setup_token']);
        return redirect()->route('assinante.login');
    }
}
