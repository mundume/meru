@extends('layouts.dashboard.main')
@section('title', 'Future Bookings')
@section('body')
<link rel="stylesheet" type="text/css" href="{{asset('/datetime/jquery.datetimepicker.css')}}" />
<div class="row">
    <div class="col-md-12 form-inline">
        <form action="{{ route('dashboard.future_bookings_check') }}" method="POST">
            @csrf
            <input type="text" class="form-control" style="height: 40px;" name="date" id="datetimepicker" placeholder="SELECT DATE">
            <select class="form-control" id="booking_office" name="fleet_id" style="height: 40px;">
                <option selected data-default disabled>Select Route</option>
                @foreach($routes as $sp)
                <option value="{{$sp->id}}">{{$sp->departure}} ~
                    {{$sp->destination}} ({{ $sp->seaters }})</option>
                @endforeach
            </select>
            <select class="form-control" name="time" id="time" style="height: 40px;">
                <option selected hidden data-default disabled>Select Time</option>
            </select>
            <button class="btn btn-success" style="height: 40px;margin:2px;" type="submit"><i data-feather="search" class="icon-sm"></i></button>
        </form>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">BOOKED TICKETS ({{ $bookings->count() }})</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="bookingTable">
                        <thead>
                            <tr>
                                <th>Ticket</th>
                                <th>Seat NO</th>
                                <th>Travel Date</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Amount</th>
                                <th>P/M</th>
                                <th>Seaters</th>
                                <th>Route</th>
                                <th>Status</th>
                                {{-- <th></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $item)
                            <tr>
                                <td>{{ $item->ticket_no }}</td>
                                <td>{{ $item->seat_no }}</td>
                                <td>{{ $item->travel_date }}</td>
                                <td>{{ $item->fullname }}</td>
                                <td>{{ $item->mobile }}</td>
                                <td>{{ number_format($item->amount, 2) }}</td>
                                <td>{{ $item->payment_method }}</td>
                                <td>{{ $item->seaters }}</td>
                                <td>{{ $item->departure }} ~ {{ $item->destination }}</td>
                                <td>
                                    @if($item->is_paid == false)
                                    <span class="badge badge-danger">Not Paid</span>
                                    @else
                                    <span class="badge badge-success">Paid</span>
                                    @endif
                                </td>
                                {{-- <td>
                                    <button class="btn btn-outline-danger btn-xs" style="margin:1px;" disabled>
                                        <i data-feather="trash" class="icon-sm"></i>
                                    </button>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('plugins/jquery/jquery-3.2.1.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#bookingTable').DataTable()
        $('#datetimepicker').datetimepicker({
            timepicker: false,
            format: "Y-m-d"
        })
    });
</script>
<script>
    $(document).ready(function () {
        $('#booking_office').on('change', function (e) {
            var cat_id = e.target.value
            $.ajax({
                url: "{{ route('dashboard.look_for_time') }}",
                type: "POST",
                data: {
                    cat_id: cat_id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    var time = ""
                    $('#time').empty()
                    var obj = jQuery.parseJSON(data)
                    $('#time').append('<option selected hidden data-default disabled> ' +
                        'Select Time</option>')
                    $.each(obj, function (propName, propVal) {
                        $('#time').append('<option>' + propVal.depart1 +
                            '</option>')
                        $('#time').append('<option>' + propVal.depart2 +
                            '</option>')
                        $('#time').append('<option>' + propVal.depart3 +
                            '</option>')
                        $('#time').append('<option>' + propVal.depart4 + '</option>')
                    })
                }
            })
        })
    })
</script>
@endsection