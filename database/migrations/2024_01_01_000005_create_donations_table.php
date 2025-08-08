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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('child_id')->nullable()->constrained('children')->onDelete('set null');
            $table->decimal('amount', 12, 2)->comment('Donation amount in IDR');
            $table->enum('type', ['uang', 'barang', 'makanan', 'pakaian', 'pendidikan', 'kesehatan', 'lainnya'])->default('uang')->comment('Type of donation');
            $table->string('description')->comment('Description of donation');
            $table->text('notes')->nullable()->comment('Additional notes about the donation');
            $table->enum('status', ['pending', 'diterima', 'digunakan', 'selesai'])->default('pending')->comment('Status of donation');
            $table->date('donation_date')->comment('Date when donation was made');
            $table->date('received_date')->nullable()->comment('Date when donation was received');
            $table->string('receipt_url')->nullable()->comment('URL to donation receipt');
            $table->json('metadata')->nullable()->comment('Additional metadata like bank transfer details');
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('user_id');
            $table->index('child_id');
            $table->index('type');
            $table->index('status');
            $table->index('donation_date');
            $table->index(['user_id', 'donation_date']);
            $table->index(['child_id', 'donation_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};