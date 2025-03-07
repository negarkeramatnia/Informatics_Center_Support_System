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
        $table->string('serial_number')->unique();
        $table->enum('status', ['available', 'assigned', 'under_maintenance'])->default('available');
        $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null'); // User the asset is assigned to
        $table->timestamps();
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
