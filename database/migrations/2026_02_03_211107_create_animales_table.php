<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('tipo', ['perro', 'gato', 'hamster', 'conejo']);
            $table->decimal('peso', 8, 2);
            $table->string('enfermedad');
            $table->text('comentarios')->nullable();
            $table->foreignId('dueno_id')->constrained('duenos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animales');
    }
};