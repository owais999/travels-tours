<?php

namespace Modules\Flight\Models;

use App\BaseModel;

class FlightCategoryTranslation extends BaseModel
{
    protected $table = 'bravo_flight_category_translations';
    protected $fillable = [
        'name',
        'content',
    ];
    protected $cleanFields = [
        'content'
    ];
}
