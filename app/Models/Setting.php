<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $primaryKey = 'key';
    public $incrementing = false; // Key is string, not auto-increment int
    protected $fillable = ['key', 'value'];

    // Helper to get array from new-line separated string
    public static function getList($key)
    {
        $setting = self::find($key);
        if (!$setting) return [];

        // Split by new line and trim whitespace
        return array_filter(array_map('trim', explode("\n", $setting->value)));
    }
}