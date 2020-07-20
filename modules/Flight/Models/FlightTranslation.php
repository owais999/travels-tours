<?php

namespace Modules\Flight\Models;

use App\BaseModel;

class FlightTranslation extends BaseModel
{
    protected $table = 'bravo_flight_translations';
    protected $fillable = [
        'title',
        'content',
        'short_desc',
        'address',
        'faqs',
        'include',
        'exclude',
        'itinerary',
    ];
    protected $slugField     = false;
    protected $seo_type = 'flight_translation';
    protected $cleanFields = [
        'content'
    ];
    protected $casts = [
        'faqs' => 'array',
        'include' => 'array',
        'exclude' => 'array',
        'itinerary' => 'array',
    ];
    public function getSeoType()
    {
        return $this->seo_type;
    }
}
