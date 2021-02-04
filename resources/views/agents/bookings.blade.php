@extends('layouts.dashboard.main')
@section('title', 'Bookings')
<link rel="stylesheet" type="text/css" href="{{asset('/datetime/jquery.datetimepicker.css')}}" />
@section('body')
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <form action="{{ route('agent.filter_booking') }}" class="form-inline float-right" method="POST">
            @csrf
            {{-- <select class="form-control" name="agent" style="margin:2px;height:42px;" required>
                <option selected data-default disabled>SELECT AGENT
                </option>
                @foreach($agents as $item)
                <option>{{ @$item->user->fname }} {{ @$item->user->lname }}</option>
            @endforeach
            </select> --}}
            <input type="text" name="date" id="date" class="form-control" style="margin:2px;height: 42px;" placeholder="SELECT DATE">
            <button class="btn btn-success" style="height: 40px;margin:2px;" type="submit"><i data-feather="search" class="icon-sm"></i></button>
        </form>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Bookings ({{ $bookings->count() }})</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="bookingTable">
                        <thead>
                            <tr>
                                <th>Ticket</th>
                                <th>Travel Date</th>
                                <th>Name</th>
                                <th>ID</th>
                                <th>Amount</th>
                                <th>P/M</th>
                                <th>Seaters</th>
                                <th>Route</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $item)
                            <tr>
                                <td>{{ $item->ticket_no }}</td>
                                <td>{{ $item->travel_date }}</td>
                                <td>{{ $item->fullname }}</td>
                                <td>{{ $item->id_no }}</td>
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
                                <td>
                                    <button class="btn btn-outline-info btn-xs" style="margin:1px;">
                                        <i data-feather="eye" class="icon-sm"></i>
                                    </button>
                                </td>
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
<script src="{{asset('/datetime/build/jquery.datetimepicker.full.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#date').datetimepicker({
            timepicker: false,
            datepicker: true,
            format: 'Y-m-d'
        })
    })
</script>
<script>
    $(document).ready(function () {
        $('#bookingTable').DataTable()
    });
</script>
@endsection