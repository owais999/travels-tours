<?php

namespace Modules\Flight\Models;

use App\BaseModel;

class FlightDate extends BaseModel
{
    protected $table = 'bravo_flight_dates';
    protected $flightMetaClass;

    protected $casts = [
        'person_types' => 'array'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->flightMetaClass = FlightMeta::class;
    }

    public static function getDatesInRanges($date, $target_id)
    {
        return static::query()->where([
            ['start_date', '>=', $date],
            ['end_date', '<=', $date],
            ['target_id', '=', $target_id],
        ])->first();
    }
    public function saveMeta(\Illuminate\Http\Request $request)
    {
        $locale = $request->input('lang');
        $meta = $this->flightMetaClass::where('flight_date_id', $this->id)->first();
        if (!$meta) {
            $meta = new $this->flightMetaClass();
            $meta->flight_date_id = $this->id;
        }
        return $meta->saveMetaOriginOrTranslation($request->input(), $locale);
    }
}
