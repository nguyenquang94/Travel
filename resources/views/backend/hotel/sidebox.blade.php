<article class="col-md-3">
    @box_open("Hotel Information")
        <div>
            <div class="widget-body">
                <a class="btn @yield("sidebox_priceset", "btn-default") btn-block" href="/hotel/{{ $hotel->id }}/priceset">Priceset</a>
                <a class="btn @yield("sidebox_priceset_weekday", "btn-default") btn-block" href="/hotel/{{ $hotel->id }}/priceset_weekday">Priceset Weekday</a>
                <a class="btn @yield("sidebox_priceset_day", "btn-default") btn-block" href="/hotel/{{ $hotel->id }}/priceset_day">Priceset day</a>
                <a class="btn @yield("sidebox_room", "btn-default") btn-block" href="/hotel/{{ $hotel->id }}/room">Room ({{ $hotel->rooms()->count() }})</a>
                <a class="btn @yield("sidebox_room_type", "btn-default") btn-block" href="/hotel/{{ $hotel->id }}/roomtype">Room Type ({{ $hotel->roomtypes()->count() }})</a>
                <a class="btn @yield("sidebox_area", "btn-default") btn-block" href="/hotel/{{ $hotel->id }}/area">Area ({{ $hotel->areas()->count() }})</a>
            </div>
        </div>
    @box_close
    @box_open("Hotel Information")
        <div>
            <div class="widget-body">
                <a class="btn @yield("sidebox_info", "btn-default") btn-block" href="/hotel/{{ $hotel->id }}/edit">Information</a>
                <a class="btn @yield("sidebox_location", "btn-default") btn-block" href="/hotel/{{ $hotel->id }}/location">Location</a>
                <a class="btn @yield("sidebox_image", "btn-default") btn-block" href="/hotel/{{ $hotel->id }}/image">Image ({{ $hotel->media()->count() }})</a>
                <a class="btn @yield("sidebox_manager", "btn-default") btn-block" href="/hotel/{{ $hotel->id }}/manager">Employee ({{ $hotel->employees()->count() }})</a>
            </div>
        </div>
    @box_close
</article>