<?php

namespace Modules\Flight\Admin;

use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\Flight\Models\Flight;
use Modules\Flight\Models\FlightCategory;

class BookingController extends AdminController
{
    protected $flightClass;
    public function __construct()
    {
        $this->setActiveMenu('admin/module/flight');
        parent::__construct();
        $this->flightClass = Flight::class;
    }

    public function index(Request $request)
    {

        $this->checkPermission('flight_create');

        $q = $this->flightClass::query();

        if ($request->query('s')) {
            $q->where('title', 'like', '%' . $request->query('s') . '%');
        }

        if ($cat_id = $request->query('cat_id')) {
            $cat = FlightCategory::find($cat_id);
            if (!empty($cat)) {
                $q->join('bravo_flight_category', function ($join) use ($cat) {
                    $join->on('bravo_flight_category.id', '=', 'bravo_flights.category_id')
                        ->where('bravo_flight_category._lft', '>=', $cat->_lft)
                        ->where('bravo_flight_category._rgt', '>=', $cat->_lft);
                });
            }
        }

        if (!$this->hasPermission('flight_manage_others')) {
            $q->where('create_user', $this->currentUser()->id);
        }

        $q->orderBy('bravo_flights.id', 'desc');

        $rows = $q->paginate(10);

        $current_month = strtotime(date('Y-m-01', time()));

        if ($request->query('month')) {
            $date = date_create_from_format('m-Y', $request->query('month'));
            if (!$date) {
                $current_month = time();
            } else {
                $current_month = $date->getTimestamp();
            }
        }

        $prev_url = url('admin/module/flight/booking/') . '?' . http_build_query(array_merge($request->query(), [
            'month' => date('m-Y', $current_month - MONTH_IN_SECONDS)
        ]));
        $next_url = url('admin/module/flight/booking/') . '?' . http_build_query(array_merge($request->query(), [
            'month' => date('m-Y', $current_month + MONTH_IN_SECONDS)
        ]));

        $flight_categories = FlightCategory::where('status', 'publish')->get()->toTree();
        $breadcrumbs = [
            [
                'name' => __('Flights'),
                'url'  => 'admin/module/flight'
            ],
            [
                'name'  => __('Booking'),
                'class' => 'active'
            ],
        ];
        $page_title = __('Flight Booking History');
        return view('Flight::admin.booking.index', compact('rows', 'flight_categories', 'breadcrumbs', 'current_month', 'page_title', 'request', 'prev_url', 'next_url'));
    }
    public function test()
    {
        $d = new \DateTime('2019-07-04 00:00:00');

        $d->modify('+ 4 hours');
        echo $d->format('Y-m-d H:i:s');
    }
}
