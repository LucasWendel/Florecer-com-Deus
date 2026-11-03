<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $fillable = [
        'order_id', 'full_name', 'published_name', 'email', 'phone',
        'country_birth', 'country_current', 'profession', 'mini_bio',
        'birthday', 'testimony_title', 'testimony_file', 'photo_file',
        'language_pref', 'social_auth', 'how_found', 'faith_aspects',
        'future_events', 'enthusiasm',
    ];
}
