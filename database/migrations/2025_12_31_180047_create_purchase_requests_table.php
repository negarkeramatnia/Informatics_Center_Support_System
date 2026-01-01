<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The requester
            $table->string('item_name');
            $table->integer('quantity')->default(1);
            $table->decimal('estimated_price', 15, 0)->nullable(); // In Tomans/Rials
            $table->string('url')->nullable(); // Link to the product
            $table->text('reason'); // Why do we need this?
            $table->enum('status', ['pending', 'approved', 'rejected', 'purchased'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};