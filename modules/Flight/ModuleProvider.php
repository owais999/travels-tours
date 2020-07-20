<?php

namespace Modules\Flight;

use Illuminate\Support\ServiceProvider;
use Modules\ModuleServiceProvider;
use Modules\Flight\Models\Flight;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
    }


    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }

    public static function getBookableServices()
    {
        return [
            'flight' => Flight::class,
        ];
    }

    public static function getAdminMenu()
    {
        $res = [];

        if (Flight::isEnable()) {
            $res['flight'] = [
                "position" => 42,
                'url'        => 'admin/module/flight',
                'title'      => __("Flight"),
                'icon'       => 'icon ion-md-umbrella',
                'permission' => 'flight_view',
                'children'   => [
                    'flight_view' => [
                        'url'        => 'admin/module/flight',
                        'title'      => __('All Flights'),
                        'permission' => 'flight_view',
                    ],
                    'flight_create' => [
                        'url'        => 'admin/module/flight/create',
                        'title'      => __("Add Flight"),
                        'permission' => 'flight_create',
                    ],
                    'flight_category' => [
                        'url'        => 'admin/module/flight/category',
                        'title'      => __('Categories'),
                        'permission' => 'flight_manage_others',
                    ],
                    'flight_attribute' => [
                        'url'        => 'admin/module/flight/attribute',
                        'title'      => __('Attributes'),
                        'permission' => 'flight_manage_attributes',
                    ],
                    'flight_availability' => [
                        'url'        => 'admin/module/flight/availability',
                        'title'      => __('Availability'),
                        'permission' => 'flight_create',
                    ],
                    'flight_booking' => [
                        'url'        => 'admin/module/flight/booking',
                        'title'      => __('Booking Calendar'),
                        'permission' => 'flight_create',
                    ],
                ]
            ];
        }
        $res;
    }


    public static function getUserMenu()
    {
        $res = [];
        if (Flight::isEnable()) {
            $res['flight'] = [
                'url'   => route('flight.vendor.index'),
                'title'      => __("Manage Flight"),
                'icon'       => Flight::getServiceIconFeatured(),
                'permission' => 'flight_view',
                'position'   => 31,
                'children'   => [
                    [
                        'url'   => route('flight.vendor.index'),
                        'title' => __("All Flights"),
                    ],
                    [
                        'url'        => route('flight.vendor.create'),
                        'title'      => __("Add Flight"),
                        'permission' => 'flight_create',
                    ],
                    [
                        'url'        => route('flight.vendor.availability.index'),
                        'title'      => __("Availability"),
                        'permission' => 'flight_create',
                    ],
                    [
                        'url'        => route('flight.vendor.booking_report'),
                        'title'      => __("Booking Report"),
                        'permission' => 'flight_view',
                    ],
                ]
            ];
        }
        return $res;
    }

    public static function getMenuBuilderTypes()
    {
        if (!Flight::isEnable()) return [];

        return [
            [
                'class' => \Modules\Flight\Models\Flight::class,
                'name'  => __("Flight"),
                'items' => \Modules\Flight\Models\Flight::searchForMenu(),
                'position' => 20
            ],
            [
                'class' => \Modules\Flight\Models\FlightCategory::class,
                'name'  => __("Flight Category"),
                'items' => \Modules\Flight\Models\FlightCategory::searchForMenu(),
                'position' => 30
            ],
        ];
    }

    public static function getTemplateBlocks()
    {
        if (!Flight::isEnable()) return [];

        return [
            'list_flights' => "\\Modules\\Flight\\Blocks\\ListFlights",
            'form_search_flight' => "\\Modules\\Flight\\Blocks\\FormSearchFlight",
        ];
    }
}
