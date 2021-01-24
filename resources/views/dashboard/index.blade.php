@extends('layouts.dashboard.main')
@section('title', 'Dashboard')
@section('body')

<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow">
            <div class="col-md-3 grid-margin stretc-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Bookings</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-12">
                                <h4 class="mb-2 mt-3">3,897</h4>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <span>+3.3%</span>
                                        <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretc-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Parcels</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-12">
                                <h4 class="mb-2 mt-3">2,520</h4>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <span>+3.3%</span>
                                        <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretc-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Fleets</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-12">
                                <h4 class="mb-2 mt-3">35,084</h4>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-danger">
                                        <span>-2.8%</span>
                                        <i data-feather="arrow-down" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretc-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Growth</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-12">
                                <h3 class="mb-2 mt-2">89.87%</h3>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <span>+2.8%</span>
                                        <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- row -->

<div class="row">
    <div class="col-12 col-xl-12 grid-margin stretch-card">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                    <h6 class="card-title mb-0">Revenue</h6>
                </div>
                <div class="flot-wrapper">
                    <div id="flotChart1" class="flot-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- row -->

<div class="row">
    <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Monthly sales</h6>
                </div>
                <div class="monthly-sales-chart-wrapper">
                    <canvas id="monthly-sales-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Bookings/Parcels proportions</h6>
                <canvas id="chartjsPie"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Available Fleets</h6>
                    <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton7">
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="pt-0">#</th>
                                <th class="pt-0">Group</th>
                                <th class="pt-0">Amount</th>
                                <th class="pt-0">Seaters</th>
                                <th class="pt-0">Route</th>
                                <th class="pt-0">Agent</th>
                                <th class="pt-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($routes as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->group }}</td>
                                    <td>KSh{{ number_format($item->amount, 2) }}</td>
                                    <td>{{ $item->seaters }}</td>
                                    <td>{{ $item->departure }} ~ {{ $item->destination }}</td>
                                    <td>
                                        {{-- {{ @$item->agent->fname }} --}}
                                    </td>
                                    <td class="form-inline float-right">
                                        <button class="btn btn-default btn-sm">
                                            <a href="{{route('dashboard.edit_route', base64_encode($item->id))}}">
                                                <i data-feather="edit"></i>
                                            </a>
                                        </button>
                                        <button class="btn btn btn-sm">
                                            <a href="{{route('route.show', base64_encode($item->id))}}">
                                                <i data-feather="globe"></i>
                                        </button>
                                        @if($item->suspend == false)
                                        <form action="{{route('dashboard.suspend_route', base64_encode($item->id))}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn btn-sm" style="margin:2px"><i data-feather="lock"></i></button>
                                        </form>
                                        @else
                                        <form action="{{route('dashboard.unsuspend_route', base64_encode($item->id))}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn btn-sm" style="margin:2px"><i data-feather="unlock"></i></button>
                                        </form>
                                        @endif
                                        {{-- @if($item->admin_suspend == false)
                                        <form action="{{route('dashboard.unsuspend_fleet', base64_encode($item->id))}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-success btn-sm" style="margin:2px"><i data-feather="lock"></i></button>
                                        </form>
                                        @else
                                        <form action="{{route('dashboard.unsuspend_fleet', base64_encode($item->id))}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-success btn-sm" style="margin:2px"><i data-feather="unlock"></i></button>
                                        </form>
                                        @endif --}}
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