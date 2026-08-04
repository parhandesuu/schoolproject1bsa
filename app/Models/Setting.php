<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Setting extends Model
{
    use LogsActivity;

    protected $fillable = ['key', 'value', 'type', 'group', 'label'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, mixed $value): void
    {
        $setting = static::firstOrNew(['key' => $key]);
        if (!$setting->exists) {
            $setting->label = ucwords(str_replace('_', ' ', $key));
            $setting->type = 'text';
            $setting->group = 'general';
        }
        $setting->value = $value;
        $setting->save();
    }
}
