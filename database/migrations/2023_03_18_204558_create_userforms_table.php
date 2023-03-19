<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('userforms', function (Blueprint $table) {
            $table->id();
            $table->string("nome", 15);
            $table->string("email", 30)->unique();
            $table->text("messaggio");
            $table->boolean("newsletter");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userforms');
    }
};