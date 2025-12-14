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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('customer_name')->nullable();
            $table->integer('total_amount'); // in kobo
            $table->string('payment_method')->default('cash');
            $table->string('status')->default('pending'); // pending, paid, returned
            $table->string('reference')->unique()->nullable();
            $table->timestamps();

            $table->index('branch_id');
            $table->index('user_id');
            $table->index('status');
            $table->index('reference');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

