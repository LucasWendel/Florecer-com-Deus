<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'subscriber_password')) {
                $table->string('subscriber_password')->nullable()->after('access_token');
            }
            if (! Schema::hasColumn('orders', 'password_set_at')) {
                $table->timestamp('password_set_at')->nullable()->after('subscriber_password');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['subscriber_password', 'password_set_at']);
        });
    }
};
