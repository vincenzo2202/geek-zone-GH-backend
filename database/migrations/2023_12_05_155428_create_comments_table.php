<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); 
            $table->text("comment")->nullable(false);
            $table->unsignedBigInteger("feed_id");
            $table->foreign("feed_id")->references("id")->on("feeds")->constrained()->onDelete('cascade');
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users")->constrained()->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
