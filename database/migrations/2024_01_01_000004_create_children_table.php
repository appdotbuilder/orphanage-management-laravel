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
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Full name of the child');
            $table->string('nickname')->nullable()->comment('Nickname or preferred name');
            $table->date('birth_date')->comment('Date of birth');
            $table->enum('gender', ['laki-laki', 'perempuan'])->comment('Gender of the child');
            $table->string('photo_url')->nullable()->comment('URL to profile photo');
            $table->text('background_story')->nullable()->comment('Background story of how they came to orphanage');
            $table->enum('education_level', ['tk', 'sd', 'smp', 'sma', 'kuliah', 'lulus'])->nullable()->comment('Current education level');
            $table->string('school_name')->nullable()->comment('Name of current school');
            $table->text('health_condition')->nullable()->comment('Health condition notes');
            $table->text('special_needs')->nullable()->comment('Special needs or requirements');
            $table->enum('status', ['aktif', 'alumni', 'pindah'])->default('aktif')->comment('Current status in orphanage');
            $table->date('entry_date')->comment('Date when child entered the orphanage');
            $table->date('exit_date')->nullable()->comment('Date when child left the orphanage (if applicable)');
            $table->text('notes')->nullable()->comment('Additional notes about the child');
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('name');
            $table->index('status');
            $table->index('education_level');
            $table->index(['status', 'created_at']);
            $table->index('birth_date');
            $table->index('entry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};