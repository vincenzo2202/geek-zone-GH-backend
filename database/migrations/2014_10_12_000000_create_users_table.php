<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable(false);
            $table->string('last_name', 100)->nullable(false);
            $table->string('email', 191)->unique()->nullable(false);
            $table->string('password')->nullable(false);
            $table->string('city')->nullable(false);
            $table->integer('phone_number')->nullable(false);
            $table->string('photo', 255)->default("https://telefe-static2.akamaized.net/media/256103/usuario-sin-foto-perfil-whatsapp.jpg");
            $table->enum('role', ['user', 'admin', 'super_admin'])->default('user');

            // $table->timestamp('created_at')->useCurrent();
            // $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
