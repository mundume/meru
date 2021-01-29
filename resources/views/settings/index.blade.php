@extends('layouts.dashboard.main')
@section('title', 'Settings')
@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success alert-dismissible" style="text-transform: uppercase;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            Online Service Portfolio
        </div>
    </div>
</div>
<br>
@if($prov)
<div class="row">
    <div class="col-md-12">
        <center>
            <h4 class="uppercase">{{$prov->c_name}}</h4>
            <br>
            <button class="btn btn-outline-success float-right" type="button" data-toggle="modal" data-target="#add_dropoffs" style="text-transform: uppercase;">
                <i data-feather="plus" class="icon-sm"></i>&nbsp;Add Dropoffs
            </button>
        </center>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        {{-- <center> --}}
        @if($drops->count() > 0)
        @foreach($drops as $drop)
        <div class="row">
            <div class="col-md-12">
                <div class="form-inline" style="justify-content: center;">
                    <button class="btn btn-outline-info" style="margin:2px;">
                        {{$drop->office_name}}
                        </button>
                        <button class="btn btn-outline-info" style="margin:2px;">
                        {{$drop->office_route}}
                    </button>
                    <button class="btn btn-outline-success" style="margin:2px;" data-toggle="modal" data-target="#edit_charge-{{$drop->id}}">
                        <i data-feather="edit" class="icon-sm"></i>
                    </button>
                    <button class="btn btn-outline-warning" style="margin:2px;" data-toggle="modal" data-target="#add_charge-{{$drop->id}}">
                        <i data-feather="plus" class="icon-sm"></i>
                    </button>
                    <form action="{{route('dashboard.delete_charge', $drop->id)}}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger" style="margin:2px;" disabled>
                            <i data-feather="trash" class="icon-sm"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal close_modal" id="add_charge-{{$drop->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="border-radius:0px;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">
                            <center style="text-transform: uppercase;">
                                Add Dropoff Charge
                                <br>
                                <small>{{$drop->office_name}}</small>
                            </center>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('dashboard.add_charge')}}" method="POST">
                            @csrf
                            <input type="hidden" name="dropoff_id" value="{{$drop->id}}">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="charge[0][name]" style="height:42px;" class="form-control" placeholder="Below 5KG*">
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="charge[0][price]" style="height:42px;" class="form-control" placeholder="KSh 150*">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="charge[1][name]" style="height:42px;" class="form-control" placeholder="Between 5KG-9KG*">
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="charge[1][price]" style="height:42px;" class="form-control" placeholder="KSh 250*">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="charge[2][name]" style="height:42px;" class="form-control" placeholder="Above 10KG*">
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="charge[2][price]" style="height:42px;" class="form-control" placeholder="KSh 450*">
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-success btn-block" style="height: 40px;">ADD CHARGE</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal close_modal" id="edit_charge-{{$drop->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="border-radius:0px;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">
                            <center style="text-transform: uppercase;">
                                View and Edit Dropoff Charge
                                <br>
                                <small>{{$drop->office_name}}</small>
                            </center>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('dashboard.edit_charge')}}" method="POST">
                            @csrf
                            <input type="hidden" name="dropoff_id" value="{{$drop->id}}">
                            @foreach($drop->charge as $data)
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="charge[0][name][]" value="{{$data->name}}" style="height:42px;" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="charge[0][price][]" style="height:42px;" class="form-control" value="{{$data->price}}">
                                </div>
                            </div>
                            <br>
                            @endforeach
                            <br>
                            @if(count($drop->charge) > 0)
                            <button type="submit" class="btn btn-success btn-block" style="height: 40px;">EDIT CHARGE</button>
                            @endif
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        <br>
        @endforeach
        <hr>
        <a href="{{route('dashboard.preview')}}" class="btn btn-success pull-right" style="text-transform: uppercase;">View &
            Activate</a>
        @else
        <h4 style="color:orange;">Oops, no dropoffs found</h4>
        @endif
        {{-- </center> --}}
    </div>
</div>
@else
<div class="row">
    <div class="col-md-12">
        <center>
            <h4 style="color:orange;">Oops, no services added</h4>
            <br>
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#add_courier" style="text-transform: uppercase;border-radius: 0px;">Add
                Online
                Service</button>
        </center>
    </div>
</div>
@endif

<div class="modal close_modal" id="add_courier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <center style="text-transform: uppercase;">Add Courier Service
                    </center>
                </h4>
            </div>
            <div class="modal-body">
                <form action="{{route('dashboard.add_provider')}}" method="POST">
                    @csrf
                    <input type="text" name="name" required style="height:42px;" class="form-control" placeholder="Shuttle App*">
                    <br>
                    <button type="submit" class="btn btn-warning btn-block" style="height:50px;">ADD SERVICE</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<div class="modal close_modal" id="add_dropoffs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <center style="text-transform: uppercase;">Add Dropoff
                    </center>
                </h4>
            </div>
            <div class="modal-body">
                <form action="{{route('dashboard.add_dropoff')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <small>Departure*</small>
                            <input type="text" name="from" required style="height:42px;" class="form-control" placeholder="FROM*">
                        </div>
                        <div class="col-md-6">
                            <small>Destination*</small>
                            <input type="text" name="to" required style="height:42px;" class="form-control" placeholder="TO*">
                            </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <small>Office name*</small>
                                    <input type="text" name="office_name" style="height: 42px;" class="form-control" placeholder="OFFICE NAME*">
                        </div>
                    </div>
                        <br>
                    <button type="submit" class="btn btn-warning btn-block" style="height: 40px;">ADD DROPOFF</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
@endsection