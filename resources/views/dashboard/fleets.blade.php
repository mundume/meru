@extends('layouts.dashboard.main')
@section('title', 'Fleets')
@section('body')
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-success float-right" style="margin:2px;" data-toggle="modal" data-target="#add_fleet">
            <i data-feather="plus" class="icon-sm"></i>&nbsp;ADD FLEET
        </button>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Fleets</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="fleetTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fleet ID</th>
                                <th>Driver Name</th>
                                <th>Driver Contact</th>
                                <th>Capacity</th>
                                <th>Date Added</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fleets as $item)
                            @php
                            if($item->suspend == true):
                            $bcolor = 'gold';
                            else:
                            $bcolor = '';
                            endif;
                            @endphp
                            <tr style="background-color: {{ $bcolor }};">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->fleet_id}}</td>
                                <td>{{$item->driver_name}}</td>
                                <td>{{$item->driver_contact}}</td>
                                <td>{{ $item->capacity }}</td>
                                <td>{{$item->created_at->format('d-m-Y')}}</td>
                                <td class="form-inline float-right">
                                    <button class="btn btn-default" data-toggle="modal" style="margin:2px" data-target="#edit_fleet_{{ $item->id }}"><i data-feather="edit" class="icon-sm"></i></button>
                                    @if($item->suspend == true)
                                    <form action="{{route('dashboard.unsuspend_fleet', base64_encode($item->id))}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success" style="margin:2px"><i data-feather="unlock" class="icon-sm"></i></button>
                                    </form>
                                    @else
                                    <form action="{{route('dashboard.suspend_fleet', base64_encode($item->id))}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-info" style="margin:2px"><i data-feather="lock" class="icon-sm"></i></button>
                                    </form>
                                    @endif
                                    <form action="{{route('dashboard.delete_fleet', base64_encode($item->id))}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" style="margin:2px"><i data-feather="trash" class="icon-sm"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <div class="modal close_modal" id="edit_fleet_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content" style="border-radius:0px;">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">
                                                <center style="text-transform: uppercase;">
                                                    Edit Fleet Details
                                                </center>
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('dashboard.edit_fleet', base64_encode($item->id))}}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" name="fleet_id" {{ $errors->has('fleet_id') ? 'has-error' : '' }} style="height:50px;" class="form-control" value="{{ $item->fleet_id }}">
                                                        <small class="text-danger">{{$errors->first('fleet_id')}}</small>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" name="driver_name" {{ $errors->has('driver_name') ? 'has-error' : '' }} style="height:50px;" class="form-control" value="{{ $item->driver_name }}">
                                                        <small class="text-danger">{{$errors->first('driver_name')}}</small>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" name="driver_contact" {{ $errors->has('driver_contact') ? 'has-error' : '' }} style="height:50px;" class="form-control" value="{{ $item->driver_contact }}">
                                                        <small class="text-danger">{{$errors->first('driver_contact')}}</small>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" name="capacity" {{ $errors->has('capacity') ? 'has-error' : '' }} style="height:50px;" class="form-control" value="{{ $item->capacity }}">
                                                        <small class="text-danger">{{$errors->first('capacity')}}</small>
                                                    </div>
                                                </div>
                                                <br>
                                                <button type="submit" class="btn btn-success btn-block" style="height: 45px;">EDIT FLEET</button>
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

<!-- pop up -->
<div class="modal close_modal" id="add_fleet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <center style="text-transform: uppercase;">
                        Fleet Details
                    </center>
                </h4>
            </div>
            <div class="modal-body">
                <form action="{{route('dashboard.add_fleet')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="fleet_id" {{ $errors->has('fleet_id') ? 'has-error' : '' }} style="height:50px;" class="form-control" placeholder="KCW 110Y *" required>
                            <small class="text-danger">{{$errors->first('fleet_id')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="driver_name" {{ $errors->has('driver_name') ? 'has-error' : '' }} style="height:50px;" class="form-control" placeholder="DRIVE NAME *" required>
                            <small class="text-danger">{{$errors->first('driver_name')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="driver_contact" {{ $errors->has('driver_contact') ? 'has-error' : '' }} style="height:50px;" class="form-control" placeholder="0712345678 *" required>
                            <small class="text-danger">{{$errors->first('driver_contact')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="capacity" {{ $errors->has('capacity') ? 'has-error' : '' }} style="height:50px;" class="form-control" placeholder="11 SEATERS (optional)">
                            <small class="text-danger">{{$errors->first('capacity')}}</small>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success btn-block" style="height: 45px;">ADD FLEET</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('plugins/jquery/jquery-3.2.1.min.js') }}"></script>
@if (count($errors) > 0)
<script>
    $(document).ready(function () {
        $('#add_fleet').modal('show')
    })
</script>
@endif
<script>
    $(document).ready(function () {
        $('#fleetTable').DataTable()
    });
</script>
@endsection