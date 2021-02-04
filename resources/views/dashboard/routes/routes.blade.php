@extends('layouts.dashboard.main')
@section('title', 'Route')
@section('body')
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
                    <table class="table table-hover mb-0" id="routeTable">
                        <thead>
                            <tr>
                                <th class="pt-0">#</th>
                                <th class="pt-0">Group</th>
                                <th class="pt-0">Amount</th>
                                <th class="pt-0">Seaters</th>
                                <th class="pt-0">Route</th>
                                <th class="pt-0">Agent</th>
                                <th class="pt-0 float-right">Overall Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($routes as $item)
                            @php
                            if($item->suspend == true):
                            $color = 'tomato';
                            else:
                            $color = '';
                            endif
                            @endphp
                            @php
                            if($item->admin_suspend == true):
                            $strike = 'line-through';
                            else:
                            $strike = '';
                            endif
                            @endphp
                            <tr style="background-color: {{ $color }};text-decoration: {{ $strike }};">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->group }}</td>
                                <td>KSh{{ number_format($item->amount, 2) }}</td>
                                <td>{{ $item->seaters }}</td>
                                <td>{{ $item->departure }} ~ {{ $item->destination }}</td>
                                <td>
                                    @foreach($item->agent as $agent)
                                    {{ @$agent->fname }} {{ @$agent->lname }}
                                    @endforeach
                                </td>
                                <td class="form-inline float-right">
                                    <button class="btn btn-default btn-sm">
                                        <a href="{{route('dashboard.edit_route', base64_encode($item->id))}}">
                                            <i data-feather="edit" class="icon-sm"></i>
                                        </a>
                                    </button>
                                    <button class="btn btn btn-sm">
                                        <a href="{{route('route.show', base64_encode($item->id))}}">
                                            <i data-feather="globe" class="icon-sm"></i>
                                    </button>
                                    @if($item->admin_suspend == false)
                                    <form action="{{route('dashboard.admin_suspend_route', base64_encode($item->id))}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm" style="margin:2px"><i data-feather="unlock" class="icon-sm"></i></button>
                                    </form>
                                    @else
                                    <form action="{{route('dashboard.admin_unsuspend_route', base64_encode($item->id))}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success btn-sm" style="margin:2px"><i data-feather="lock" class="icon-sm"></i></button>
                                    </form>
                                    @endif
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
        $('#routeTable').DataTable()
    });
</script>
@endsection