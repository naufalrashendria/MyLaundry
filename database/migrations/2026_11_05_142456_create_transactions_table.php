<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('customer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_phone', 20)->nullable();
            $table->foreignId('service_id')->constrained()->restrictOnDelete();
            $table->decimal('weight', 8, 2)->default(0);
            $table->unsignedInteger('price');              // harga saat order (snapshot)
            $table->unsignedBigInteger('total')->default(0);
            $table->string('status')->default('pending')->index();
            $table->string('payment_status')->default('unpaid');
            $table->string('source')->default('walk_in');  // walk_in / online
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('due_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};