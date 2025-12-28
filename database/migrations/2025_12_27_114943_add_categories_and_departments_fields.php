<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add Category to Tickets
        Schema::table('tickets', function (Blueprint $table) {
            $table->enum('category', [
                'software', 
                'hardware', 
                'network', 
                'access_control', 
                'other'
            ])->after('title')->default('other');
        });

        // 2. Add Department to Users (Feature 6)
        Schema::table('users', function (Blueprint $table) {
            $table->string('department')->nullable()->after('email'); 
            // Examples: 'HR', 'Finance', 'Engineering', 'Office_A'
        });

        // 3. Add Department/Location ID to Assets if strictly needed
        // Note: Your assets table already has a 'location' string. 
        // We will standardise this to match user departments later.
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('category');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('department');
        });
    }
};