<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'description'
    ];

    protected $casts = [
        'value' => 'string'
    ];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        $cacheKey = "setting.{$key}";
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }
            
            return static::castValue($setting->value, $setting->type);
        });
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value, $type = 'string', $description = null)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'description' => $description
            ]
        );
        
        // Clear cache
        Cache::forget("setting.{$key}");
        
        return $setting;
    }

    /**
     * Cast value based on type
     */
    protected static function castValue($value, $type)
    {
        switch ($type) {
            case 'integer':
                return (int) $value;
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'json':
                return json_decode($value, true);
            case 'float':
                return (float) $value;
            default:
                return $value;
        }
    }

    /**
     * Get daily goal setting
     */
    public static function getDailyGoal()
    {
        return static::get('daily_goal', 3); // Default 3 submissions per day
    }

    /**
     * Get weekly goal setting
     */
    public static function getWeeklyGoal()
    {
        return static::get('weekly_goal', 20); // Default 20 submissions per week
    }

    /**
     * Get monthly goal setting
     */
    public static function getMonthlyGoal()
    {
        return static::get('monthly_goal', 80); // Default 80 submissions per month
    }

    /**
     * Set daily goal
     */
    public static function setDailyGoal($value)
    {
        return static::set('daily_goal', $value, 'integer', 'Daily submission goal for agents');
    }

    /**
     * Set weekly goal
     */
    public static function setWeeklyGoal($value)
    {
        return static::set('weekly_goal', $value, 'integer', 'Weekly submission goal for agents');
    }

    /**
     * Set monthly goal
     */
    public static function setMonthlyGoal($value)
    {
        return static::set('monthly_goal', $value, 'integer', 'Monthly submission goal for agents');
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        $settings = static::all();
        foreach ($settings as $setting) {
            Cache::forget("setting.{$setting->key}");
        }
    }
}