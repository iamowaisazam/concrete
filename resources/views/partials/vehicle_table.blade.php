@if(count($vehicles))
<table class="table">
    <thead>
        <tr>
            <th>Vehicle</th>
            <th>Lot No</th>
            <th>Auction Date</th>
            <th>Year</th>
            <th>CC</th>
            <th>Mileage</th>
            <th>Transmission</th>
        </tr>
    </thead>
    <tbody>
        @foreach($vehicles as $vehicle)
        <tr>
            <td>
                {{ $vehicle->make->name ?? '' }}
                {{ $vehicle->model->name ?? '' }}
                {{ $vehicle->variant->name ?? '' }}
            </td>
            <td>{{ $vehicle->auction->lot_number ?? '-' }}</td>
            <td>{{ $vehicle->auction->auction_date ?? '-' }}</td>
            <td>{{ $vehicle->year->year ?? '-' }}</td>
            <td>{{ $vehicle->cc ?? '-' }}</td>
            <td>{{ $vehicle->mileage ?? '-' }}</td>
            <td>{{ $vehicle->transmission ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
    <div class="alert alert-warning">No vehicles found matching the filters.</div>
@endif
