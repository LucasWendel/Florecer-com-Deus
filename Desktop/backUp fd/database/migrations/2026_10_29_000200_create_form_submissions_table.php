<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('full_name')->nullable();
            $table->string('published_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('country_birth', 100)->nullable();
            $table->string('country_current', 100)->nullable();
            $table->string('profession')->nullable();
            $table->text('mini_bio')->nullable();
            $table->string('birthday', 20)->nullable();
            $table->string('testimony_title')->nullable();
            $table->string('testimony_file', 500)->nullable();
            $table->string('photo_file', 500)->nullable();
            $table->string('language_pref', 5)->nullable();
            $table->string('social_auth', 5)->nullable();
            $table->string('how_found', 100)->nullable();
            $table->string('faith_aspects', 500)->nullable();
            $table->string('future_events', 20)->nullable();
            $table->tinyInteger('enthusiasm')->nullable();
            $table->timestamps();
            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};
