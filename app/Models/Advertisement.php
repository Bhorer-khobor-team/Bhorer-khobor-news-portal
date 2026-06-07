<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class Advertisement extends Model
{
    protected $fillable = [
        'title', 'image', 'link', 'position', 'advertiser_name',
        'advertiser_contact', 'is_active', 'starts_at', 'ends_at',
    ];


    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
    ];


    // Scope: only active ads that are within their date range
    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('is_active', true)
            ->where(function ($q) use ($now) {
                // starts_at is null (no start restriction) OR already started
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                // ends_at is null (no end restriction) OR not yet expired
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
            });
    }


    // 7 named positions — KEYS are stored in DB, labels shown in dropdown
    public static function positions(): array
    {
        return [
            'header'         => 'Header Banner',
            'home_top'       => 'Home Top',
            'home_middle'    => 'Home Middle',
            'home_bottom'    => 'Home Bottom',
            'sidebar_top'    => 'Sidebar Top',
            'sidebar_middle' => 'Sidebar Middle',
            'article_inline' => 'Article Inline',
        ];
    }
}

