<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id(); 
            $table->text("message")->nullable(false);
            $table->unsignedBigInteger("chat_id");
            $table->foreign("chat_id")->references("id")->on("chats")->constrained()->onDelete('cascade');
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users")->constrained()->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
