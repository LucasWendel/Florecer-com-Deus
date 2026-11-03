<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\FormSubmission;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private const ADMIN_EMAIL    = 'dashboard@gracehub.com';
    private const ADMIN_PASSWORD_HASH = '$2y$10$qjhnCMSzJcVFjptVVzLmEufVG8fb2N8.a7njIX0s9sT.TM1aLavye';

    /** Exibe a tela de login do admin. */
    public function login()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    /** Processa o login do admin. */
    public function doLogin(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Informe o e-mail.',
            'password.required' => 'Informe a senha.',
        ]);

        if (strtolower(trim($request->email)) === self::ADMIN_EMAIL && password_verify($request->password, self::ADMIN_PASSWORD_HASH)) {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Credenciais inválidas.'])->withInput(['email' => $request->email]);
    }

    /** Painel principal do admin. */
    public function dashboard(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $search = trim((string) $request->get('search', ''));
        $query  = Order::where('status', 'paid');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name',      'like', "%{$search}%")
                  ->orWhere('customer_email',    'like', "%{$search}%")
                  ->orWhere('customer_whatsapp', 'like', "%{$search}%");
            });
        }

        $subscribers = $query->with('formSubmission')->orderByDesc('created_at')->get();

        // Contagem diária dos últimos 7 dias
        $dailyCounts = Order::where('status', 'paid')
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $todayCount = Order::where('status', 'paid')->whereDate('created_at', today())->count();
        $totalCount = Order::where('status', 'paid')->count();

        return view('admin.dashboard', compact('subscribers', 'dailyCounts', 'todayCount', 'totalCount', 'search'));
    }

    /** Exibe formulário de edição de assinante. */
    public function edit(int $id)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        $order = Order::findOrFail($id);
        return view('admin.edit', compact('order'));
    }

    /** Salva alterações do assinante. */
    public function update(Request $request, int $id)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'customer_name'      => ['required', 'string', 'max:255'],
            'customer_email'     => ['required', 'email', 'max:255'],
            'customer_whatsapp'  => ['nullable', 'string', 'max:30'],
        ]);

        $order->update($validated);
        return redirect()->route('admin.dashboard')->with('success', 'Assinante atualizado com sucesso.');
    }

    /** Exclui assinante. */
    public function delete(int $id)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        Order::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Assinante excluído com sucesso.');
    }

    /** Redefine a senha do assinante (força novo cadastro no próximo acesso). */
    public function resetPassword(int $id)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $order = Order::findOrFail($id);
        $order->subscriber_password = null;
        $order->password_set_at     = null;
        $order->save();

        return redirect()->route('admin.dashboard')->with('success', 'Senha do assinante redefinida. No próximo acesso ele criará uma nova senha.');
    }

    /** Exibe as respostas do formulário de uma coautora. */
    public function formView(int $id)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        $order      = Order::findOrFail($id);
        $submission = FormSubmission::where('order_id', $id)->first();
        return view('admin.form-view', compact('order', 'submission'));
    }

    /** Download seguro de arquivo de testemunho ou foto enviados pela coautora. */
    public function downloadFile(int $id, string $tipo)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        $submission = FormSubmission::where('order_id', $id)->firstOrFail();
        $path = match ($tipo) {
            'testemunho' => $submission->testimony_file,
            'foto'       => $submission->photo_file,
            default      => null,
        };
        if (! $path || ! file_exists(public_path($path))) {
            abort(404, 'Arquivo não encontrado.');
        }
        return response()->download(public_path($path));
    }

    /** Logout do admin. */
    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    /** Exporta todos os inscritos pagos em Excel (.xlsx nativo; CSV se ZipArchive indisponível). */
    public function exportExcel(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $simbolos = ['brl' => 'R$', 'usd' => 'US$', 'eur' => '€'];
        $subscribers = Order::where('status', 'paid')->orderByDesc('created_at')->get();

        $rows = [['Data', 'Nome', 'E-mail', 'WhatsApp', 'Valor', 'ID Stripe', 'Senha']];
        foreach ($subscribers as $s) {
            $cur = strtolower($s->currency ?: 'brl');
            $rows[] = [
                (string) optional($s->created_at)->format('d/m/Y H:i'),
                (string) $s->customer_name,
                (string) $s->customer_email,
                (string) $s->customer_whatsapp,
                ($simbolos[$cur] ?? strtoupper($cur)) . ' ' . number_format($s->amount / 100, 2, ',', '.'),
                (string) $s->checkout_session_id,
                $s->password_set_at ? 'Criada' : 'Pendente',
            ];
        }

        $base = 'inscritos_florescer_' . now()->format('Ymd_His');

        if (! class_exists(\ZipArchive::class)) {
            return response()->streamDownload(function () use ($rows) {
                $out = fopen('php://output', 'w');
                fwrite($out, "\xEF\xBB\xBF");
                foreach ($rows as $r) { fputcsv($out, $r, ';'); }
                fclose($out);
            }, $base . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
        }

        $esc = fn ($v) => htmlspecialchars($v, ENT_XML1 | ENT_QUOTES, 'UTF-8');
        $col = function (int $n) { $l = ''; $n++; while ($n > 0) { $m = ($n - 1) % 26; $l = chr(65 + $m) . $l; $n = intdiv($n - 1, 26); } return $l; };

        $sheetRows = '';
        foreach ($rows as $ri => $r) {
            $rn = $ri + 1;
            $sheetRows .= '<row r="' . $rn . '">';
            foreach ($r as $ci => $v) {
                $style = $ri === 0 ? ' s="1"' : '';
                $sheetRows .= '<c r="' . $col($ci) . $rn . '" t="inlineStr"' . $style . '><is><t xml:space="preserve">' . $esc($v) . '</t></is></c>';
            }
            $sheetRows .= '</row>';
        }
        $widths = [18, 32, 34, 20, 14, 40, 12];
        $cols = '<cols>';
        foreach ($widths as $k => $w) { $cols .= '<col min="' . ($k + 1) . '" max="' . ($k + 1) . '" width="' . $w . '" customWidth="1"/>'; }
        $cols .= '</cols>';

        $files = [
            '[Content_Types].xml' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/><Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/></Types>',
            '_rels/.rels' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>',
            'xl/workbook.xml' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets><sheet name="Inscritos" sheetId="1" r:id="rId1"/></sheets></workbook>',
            'xl/_rels/workbook.xml.rels' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/></Relationships>',
            'xl/styles.xml' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><fonts count="2"><font><sz val="11"/><name val="Calibri"/></font><font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font></fonts><fills count="3"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill><fill><patternFill patternType="solid"><fgColor rgb="FF4F6B4F"/></patternFill></fill></fills><borders count="1"><border/></borders><cellStyleXfs count="1"><xf/></cellStyleXfs><cellXfs count="2"><xf/><xf fontId="1" fillId="2" applyFont="1" applyFill="1"/></cellXfs></styleSheet>',
            'xl/worksheets/sheet1.xml' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><sheetViews><sheetView workbookViewId="0"><pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/></sheetView></sheetViews>' . $cols . '<sheetData>' . $sheetRows . '</sheetData><autoFilter ref="A1:G' . count($rows) . '"/></worksheet>',
        ];

        $tmp = tempnam(storage_path('app'), 'xlsx');
        $zip = new \ZipArchive();
        $zip->open($tmp, \ZipArchive::OVERWRITE);
        foreach ($files as $name => $content) { $zip->addFromString($name, $content); }
        $zip->close();

        return response()->download($tmp, $base . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

}
