<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary(); // e.g., 'departments'
            $table->text('value')->nullable(); // e.g., 'IT, HR, Finance'
            $table->timestamps();
        });

        // Insert Default Data immediately so the app doesn't break
        DB::table('settings')->insert([
            ['key' => 'departments', 'value' => "مدیریت\nفناوری اطلاعات\nمنابع انسانی\nمالی\nحراست\nخدمات مشترکین\nفنی و مهندسی", 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'ticket_categories', 'value' => "software\nhardware\nnetwork\naccess_control\nother", 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};