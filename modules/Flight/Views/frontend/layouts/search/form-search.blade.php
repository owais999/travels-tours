<form action="{{ route("flight.search") }}" class="form bravo_form" method="get">
    <div class="g-field-search">
        <div class="row">
            @php $flight_search_fields = setting_item_array('flight_search_fields');
            $flight_search_fields = array_values(\Illuminate\Support\Arr::sort($flight_search_fields, function ($value) {
            return $value['position'] ?? 0;
            }));
            @endphp
            @if(!empty($flight_search_fields))
            @foreach($flight_search_fields as $field)
            <div class="col-md-{{ $field['size'] ?? "6" }} border-right">
                @switch($field['field'])
                @case ('service_name')
                @include('Flight::frontend.layouts.search.fields.service_name')
                @break
                @case ('location')
                @include('Flight::frontend.layouts.search.fields.location')
                @break
                @case ('tolocation')
                @include('Flight::frontend.layouts.search.fields.tolocation')
                @break
                @case ('date')
                @include('Flight::frontend.layouts.search.fields.date')
                @break
                @case ('travellers')
                @include('Flight::frontend.layouts.search.fields.travellers')
                @break
                @case ('cabinclass')
                @include('Flight::frontend.layouts.search.fields.cabinclass')
                @break
                @case ('addnearbyairports')
                @include('Flight::frontend.layouts.search.fields.addnearbyairports')
                @break
                @case ('flighttype')
                @include('Flight::frontend.layouts.search.fields.flighttype')
                @break
                @endswitch
            </div>
            @endforeach
            @endif
        </div>
    </div>
    <div class="g-button-submit">
        <button class="btn btn-primary btn-search" type="submit">{{__("Search")}}</button>
    </div>
</form>