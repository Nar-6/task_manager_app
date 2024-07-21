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
        Schema::create('taches', function (Blueprint $table) {
            $table->id('num_tache');
            $table->string('nom_tache');
            $table->text('description')->nullable();
            $table->string('assigne_a')->nullable(); // Email to assign the task
            $table->enum('priorite', ['High', 'Medium', 'Low'])->default('Medium'); // Task priority
            $table->enum('statut', ['À faire', 'En cours', 'Terminé'])->default('À faire'); // Task status
            $table->foreign('assigne_a')->references('email')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
