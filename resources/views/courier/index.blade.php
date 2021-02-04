@extends('layouts.dashboard.main')
@section('title', 'Dashboard')
@section('body')
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow">
            {{-- <div class="col-md-3 grid-margin stretc-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Parcels</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-12">
                                <h4 class="mb-2 mt-3">45</h4>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <i data-feather="globe" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-3 grid-margin stretc-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Parcels</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-12">
                                <h4 class="mb-2 mt-3">{{ $count_parcels }}</h4>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <i data-feather="map" class="icon-sm mb-1"></i>
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
                                <h4 class="mb-2 mt-3">{{ $fleets->count() }}</h4>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <i data-feather="truck" class="icon-md mb-1"></i>
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
</div>

<br>

<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Yesterday's Parcel</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="parcelTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>#/N</th>
                                <th>Sender Name</th>
                                <th>Receiver Name</th>
                                <th>Receiver Mobile</th>
                                <th>ID</th>
                                <th>Destination</th>
                                <th>Fleet</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($parcels as $item)
                            <tr>
                                <td class="form-inline">
                                    @if($item->progress == false)
                                    <form action="{{route('dashboard.progress', $item->id)}}" method="POST">
                                        @csrf
                                        <button class="btn btn-success" type="submit" style="margin:2px;">
                                            <i data-feather="check" class="icon-sm"></i>
                                        </button>
                                    </form>
                                    <button class="btn btn-outline-warning" disabled style="margin:2px;">
                                        <i data-feather="edit" class="icon-sm"></i>
                                    </button>
                                    @else
                                    <form action="{{route('dashboard.print_parcel', $item->parcel_no)}}" method="POST">
                                        @csrf
                                        <button class="btn btn-outline-warning" style="margin:2px;"><i data-feather="printer" class="icon-sm"></i></button>
                                    </form>
                                    <button class="btn btn-success" data-toggle="modal" style="margin:2px;" data-target="#edit_parcel_{{ $item->parcel_no }}">
                                        <i data-feather="edit" class="icon-sm"></i>
                                    </button>
                                    @endif
                                </td>
                                @if($item->picked == false)
                                <td>{{$item->parcel_no}}</td>
                                @else
                                <td style="background-color:#bada55;color:white;">{{$item->parcel_no}}</td>
                                @endif
                                <td>{{$item->sender_name}}</td>
                                <td>{{$item->receiver_name}}</td>
                                <td>{{$item->receiver_mobile}}</td>
                                <td>{{$item->id_no}}</td>
                                <td>{{@$item->dropoff->office_route}}</td>
                                <td>{{@$item->fleet->fleet_id}}</td>
                                <td>
                                    @if($item->is_paid == false)
                                    <span class="badge badge-danger">Not Paid</span>
                                    @else
                                    <span class="badge badge-success">Paid</span>
                                    @endif
                                </td>
                            </tr>
                            <div class="modal close_modal" id="edit_parcel_{{ $item->parcel_no }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content" style="border-radius:0px;">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">
                                                <center style="text-transform: uppercase;">Fleet Information | {{ $item->parcel_no }}
                                                </center>
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('dashboard.parcel_assign_fleet', $item->parcel_no)}}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                                        <select name="fleet_id" {{ $errors->has('fleet_id') ? 'has-error' : '' }} style="height: 45px;" class="form-control" required>
                                                            <option selected hidden data-default disabled>SELECT FLEET
                                                            </option>
                                                            @foreach($fleets as $fleet)
                                                            <option value="{{ $fleet->id }}">{{ $fleet->fleet_id }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>
                                                <button type="submit" class="btn btn-success btn-block" style="height:42px;">ASSIGN FLEET PARCEL</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        $('#parcelTable').DataTable()
    });
</script>
@endsection