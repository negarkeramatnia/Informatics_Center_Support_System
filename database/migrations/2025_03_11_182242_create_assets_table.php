<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('assets', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        $table->string('serial_number')->unique();
        $table->date('purchase_date')->nullable();
        $table->date('warranty_expiration')->nullable();
        $table->enum('status', ['available', 'assigned', 'under_maintenance', 'expired'])->default('available');
        $table->string('location')->nullable();
        $table->unsignedBigInteger('assigned_to')->nullable();
        $table->timestamps();

        // Foreign key
        $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
