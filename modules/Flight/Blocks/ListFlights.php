<?php

namespace Modules\Flight\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\Flight\Models\Flight;
use Modules\Flight\Models\FlightCategory;
use Modules\Location\Models\Location;

class ListFlights extends BaseBlock
{
    function __construct()
    {
        $this->setOptions([
            'settings' => [
                [
                    'id'        => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title')
                ],
                [
                    'id'        => 'desc',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Desc')
                ],
                [
                    'id'        => 'number',
                    'type'      => 'input',
                    'inputType' => 'number',
                    'label'     => __('Number Item')
                ],
                [
                    'id'            => 'style',
                    'type'          => 'radios',
                    'label'         => __('Style'),
                    'values'        => [
                        [
                            'value'   => 'normal',
                            'name' => __("Normal")
                        ],
                        [
                            'value'   => 'carousel',
                            'name' => __("Slider Carousel")
                        ],
                        [
                            'value'   => 'box_shadow',
                            'name' => __("Box Shadow")
                        ]
                    ]
                ],
                [
                    'id'      => 'category_id',
                    'type'    => 'select2',
                    'label'   => __('Filter by Category'),
                    'select2' => [
                        'ajax'  => [
                            'url'      => url('/admin/module/flight/category/getForSelect2'),
                            'dataType' => 'json'
                        ],
                        'width' => '100%',
                        'allowClear' => 'true',
                        'placeholder' => __('-- Select --')
                    ],
                    'pre_selected' => url('/admin/module/flight/category/getForSelect2?pre_selected=1')
                ],
                [
                    'id'      => 'location_id',
                    'type'    => 'select2',
                    'label'   => __('Filter by Location'),
                    'select2' => [
                        'ajax'  => [
                            'url'      => url('/admin/module/location/getForSelect2'),
                            'dataType' => 'json'
                        ],
                        'width' => '100%',
                        'allowClear' => 'true',
                        'placeholder' => __('-- Select --')
                    ],
                    'pre_selected' => url('/admin/module/location/getForSelect2?pre_selected=1')
                ],
                [
                    'id'            => 'order',
                    'type'          => 'radios',
                    'label'         => __('Order'),
                    'values'        => [
                        [
                            'value'   => 'id',
                            'name' => __("Date Create")
                        ],
                        [
                            'value'   => 'title',
                            'name' => __("Title")
                        ],
                    ]
                ],
                [
                    'id'            => 'order_by',
                    'type'          => 'radios',
                    'label'         => __('Order By'),
                    'values'        => [
                        [
                            'value'   => 'asc',
                            'name' => __("ASC")
                        ],
                        [
                            'value'   => 'desc',
                            'name' => __("DESC")
                        ],
                    ]
                ],
                [
                    'type' => "checkbox",
                    'label' => __("Only featured items?"),
                    'id' => "is_featured",
                    'default' => true
                ]
            ]
        ]);
    }

    public function getName()
    {
        return __('Flight: List Items');
    }

    public function content($model = [])
    {
        $model_Flight = Flight::select("bravo_flights.*")->with(['location', 'translations', 'hasWishList']);
        if (empty($model['order'])) $model['order'] = "id";
        if (empty($model['order_by'])) $model['order_by'] = "desc";
        if (empty($model['number'])) $model['number'] = 5;
        if (!empty($model['location_id'])) {
            $location = Location::where('id', $model['location_id'])->where("status", "publish")->first();
            if (!empty($location)) {
                $model_Flight->join('bravo_locations', function ($join) use ($location) {
                    $join->on('bravo_locations.id', '=', 'bravo_flights.location_id')
                        ->where('bravo_locations._lft', '>=', $location->_lft)
                        ->where('bravo_locations._rgt', '<=', $location->_rgt);
                });
            }
        }
        if (!empty($model['category_id'])) {
            $category_ids = [$model['category_id']];
            $list_cat = FlightCategory::whereIn('id', $category_ids)->where("status", "publish")->get();
            if (!empty($list_cat)) {
                $where_left_right = [];
                foreach ($list_cat as $cat) {
                    $where_left_right[] = " ( bravo_flight_category._lft >= {$cat->_lft} AND bravo_flight_category._rgt <= {$cat->_rgt} ) ";
                }
                $sql_where_join = " ( " . implode("OR", $where_left_right) . " )  ";
                $model_Flight
                    ->join('bravo_flight_category', function ($join) use ($sql_where_join) {
                        $join->on('bravo_flight_category.id', '=', 'bravo_flights.category_id')
                            ->WhereRaw($sql_where_join);
                    });
            }
        }
        if (!empty($model['is_featured'])) {
            $model_Flight->where('is_featured', 1);
        }
        $model_Flight->orderBy("bravo_flights." . $model['order'], $model['order_by']);
        $model_Flight->where("bravo_flights.status", "publish");
        $model_Flight->with('location');
        $model_Flight->groupBy("bravo_flights.id");
        $list = $model_Flight->limit($model['number'])->get();
        $data = [
            'rows'       => $list,
            'style_list' => $model['style'],
            'title'      => $model['title'] ?? "",
            'desc'      => $model['desc'] ?? "",
        ];
        return view('Flight::frontend.blocks.list-flight.index', $data);
    }
}
