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
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id'); // PK auto-increment
            $table->string('name'); // obrigatório
            $table->string('email')->unique(); // obrigatório, único
            $table->string('phone'); // obrigatório
            $table->integer('score')->default(0); // default 0
            $table->enum('status', ['pending', 'processing', 'active', 'failed'])->default('pending'); // enum
            $table->timestamp('processed_at')->nullable(); // preenchido após processamento
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact');
    }
};
