<article class="col-md-3">
    @box_open("Hotel Information")
        <div>
            <div class="widget-body">
                <a class="btn @yield("sidebox_ticket", "btn-default") btn-block" href="/bus/{{ $bus->id }}/ticket">Ticket ({{ $bus->tickets()->count() }})</a>
                <a class="btn @yield("sidebox_trip", "btn-default") btn-block" href="/bus/{{ $bus->id }}/trip">Trip ({{ $bus->trips()->count() }})</a>
                <a class="btn @yield("sidebox_priceset", "btn-default") btn-block" href="/bus/{{ $bus->id }}/priceset">Priceset ({{ $bus->pricesets()->count() }})</a>
                <a class="btn @yield("sidebox_type", "btn-default") btn-block" href="/bus/{{ $bus->id }}/type">Type ({{ $bus->types()->count() }})</a>
            </div>
        </div>
    @box_close
    @box_open("Hotel Information")
        <div>
            <div class="widget-body">
                <a class="btn @yield("sidebox_info", "btn-default") btn-block" href="/bus/{{ $bus->id }}/edit">Info</a>
                <a class="btn @yield("sidebox_manager", "btn-default") btn-block" href="/bus/{{ $bus->id }}/manager">Employee ({{ $bus->employees()->count() }})</a>
            </div>
        </div>
    @box_close
</article>