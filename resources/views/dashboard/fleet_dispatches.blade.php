@extends('layouts.dashboard.main')
@section('title', 'Fleet Dispatches')
@section('body')
<link rel="stylesheet" type="text/css" href="{{asset('/datetime/jquery.datetimepicker.css')}}" />
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <form action="{{ route('dashboard.search_dispatches') }}" class="form-inline float-right" method="POST">
            @csrf
            <input class="form-control" name="date" style="height:42px;" id="date" placeholder="SEARCH BY DATE">
            <button class="btn btn-success" style="height:40px;margin-left:5px;"><i data-feather="search" class="icon-sm" type="submit"></i></button>
        </form>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Dispatches</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="dispatchTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fleet Number</th>
                                <th>Date Dispatched</th>
                                <th>Time Dispatched</th>
                                <th>Route</th>
                                <th>Seaters</th>
                                <th>Commuters</th>
                                <th>Cash</th>
                                <th>Mpesa</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dispatchs as $dispatch)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($dispatch->created_at > Carbon\Carbon::now())
                                    <strike style="text-transform: uppercase;">
                                        {{$dispatch->readable_fleet_id}}
                                    </strike>
                                    @else
                                    <p style="text-transform: uppercase;">{{$dispatch->readable_fleet_id}}</p>
                                    @endif
                                </td>
                                <td>
                                    @if($dispatch->created_at > Carbon\Carbon::now())
                                    <strike>
                                        {{ $dispatch->created_at->format('d-m-Y') }}
                                    </strike>
                                    @else
                                    {{ $dispatch->created_at->format('d-m-Y') }}
                                    @endif
                                </td>
                                <td>{{ $dispatch->created_at->format('h:i') }}</td>
                                <td>{{ $dispatch->route[0]->departure }} ~ {{ $dispatch->route[0]->destination }}</td>
                                <td>{{$dispatch->route[0]->seaters}}</td>
                                <td>{{ $dispatch->no_of_commuters }}</td>
                                <td>{{ number_format($dispatch->cash, 2) }}</td>
                                <td>{{ number_format($dispatch->mpesa, 2) }}</td>
                                <td>{{ number_format($dispatch->total_amount, 2) }}</td>
                                <td class="form-inline">
                                    <form action="{{route('dashboard.dispatch_fleet_print', $dispatch->fleet_id)}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-warning" style="margin:2px;">
                                            <i data-feather="printer" class="icon-sm"></i>
                                        </button>
                                    </form>
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
        $('#dispatchTable').DataTable({
            "drawCallback": function (settings) {
        feather.replace()
        }
        })
    });
</script>
@endsection