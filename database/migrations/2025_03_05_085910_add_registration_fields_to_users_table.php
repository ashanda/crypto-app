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
        Schema::table('users', function (Blueprint $table) {
            $table->string('whatsapp_number')->nullable();
            $table->string('binance_pay_id')->nullable();
            $table->enum('status', ['pending', 'active', 'inactive'])->default('pending');
            $table->foreignId('referred_by')->nullable()->constrained('users')->onDelete('set null');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_number', 'binance_pay_id', 'status', 'referred_by', 'package']);
        });
    }
};
