<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkout_session_id',
        'customer_name',
        'customer_whatsapp',
        'customer_email',
        'amount',
        'currency',
        'status',
        'access_token',
        'subscriber_password',
        'password_set_at',
    ];

    protected $hidden = ['subscriber_password'];

    protected $casts = [
        'password_set_at' => 'datetime',
    ];
    public function formSubmission()
    {
        return $this->hasOne(\App\Models\FormSubmission::class, 'order_id');
    }
}