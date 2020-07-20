@if(count($flight_related) > 0)
<div class="bravo-list-flight-related">
    <h2>{{__("You might also like")}}</h2>
    <div class="row">
        @foreach($flight_related as $k=>$item)
        <div class="col-md-3">
            @include('Flight::frontend.layouts.search.loop-gird',['row'=>$item,'include_param'=>0])
        </div>
        @endforeach
    </div>
</div>
@endif