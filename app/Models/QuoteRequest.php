<?php

namespace App\Models;

use Database\Factories\QuoteRequestFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteRequest extends Model
{
    /** @use HasFactory<QuoteRequestFactory> */
    use HasFactory;

    public const SITE_TYPES = [
        'Office',
        'School/campus',
        'Hospital',
        'Bank/SACCO',
        'Hotel/restaurant',
        'Retail',
        'Residential',
        'Industrial',
        'Other',
    ];

    public const TIMELINES = [
        'Immediately',
        'Within a month',
        '1–3 months',
        'Planning/budgeting',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'service_id',
        'product',
        'location',
        'site_type',
        'timeline',
        'budget_range',
        'details',
        'needs_site_survey',
        'ip_address',
        'user_agent',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'needs_site_survey' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<Service, $this>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
