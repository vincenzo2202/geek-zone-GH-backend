<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable(false);
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users")->constrained()->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }
  
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
