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
        Schema::create('isa_analises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('isa_id')->constrained('isas')->onDelete('cascade');
    $table->text('data_mentah'); // bisa dalam bentuk JSON/text
    $table->enum('sentimen', ['positif', 'negatif', 'netral']);
    $table->string('sumber'); // username atau link post
    $table->dateTime('tanggal');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('isa_analises');
    }
};
