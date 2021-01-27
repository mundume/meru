@extends('layouts.dashboard.main')
@section('title', 'Add Parcel')
<link rel="stylesheet" type="text/css" href="{{asset('/datetime/jquery.datetimepicker.css')}}" />
@section('body')
<div class="row">
    <div class="col-md-6">
        <button class="btn btn-outline-warning" data-toggle="modal" data-target="#print_dispatch">
            <i data-feather="printer" class="icon-sm"></i>&nbsp;PRINT
        </button>
    </div>
    <div class="col-md-6">
        <button class="btn btn-success float-right" data-toggle="modal" data-target="#add_parcel">
            <i data-feather="plus" class="icon-sm"></i>&nbsp;RECEIVE PARCEL
        </button>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Today's Parcel ({{ $parcels->count() }})</h6>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($parcels as $item)
                            <tr>
                                <td class="form-inline">
                                    @if($item->progress == false)
                                    <form action="{{route('courier.progress', $item->id)}}" method="POST">
                                        @csrf
                                        <button class="btn btn-success"><i data-feather="check" class="icon-sm"></i></button>
                                    </form>
                                    <button class="btn btn-default btn-sm" disabled>
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    @else
                                    <form action="{{route('print_parcel', $item->parcel_no)}}" method="POST">
                                        @csrf
                                        <button class="btn btn-outline-warning"><i data-feather="printer" class="icon-sm"></i></button>
                                    </form>
                                    <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#edit_parcel_{{ $item->parcel_no }}">
                                        <i data-feather="edit" class="icon-s,"></i>
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
                                <td>{{$item->dropoff->name}}</td>
                                <td>{{@$item->fleet->fleet_id}}</td>
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
                                            <form action="{{route('parcel_assign_fleet', $item->parcel_no)}}" method="POST">
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

<div class="modal close_modal" id="add_parcel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <center style="text-transform: uppercase;">Add Parcel
                    </center>
                </h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible" style="text-transform: uppercase;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    Enter Parcel Information.
                </div>
                @if ($errors->coo->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->coo->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{route('dashboard.post_parcel')}}" method="POST" class="parcel_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 {{ $errors->has('sender_name') ? 'has-error' : '' }}">
                            <small>Sender name*</small>
                            <input type="text" name="sender_name" class="input-group form-control" placeholder="SENDER NAME*" style="height:45px;" required>
                        </div>
                        <div class="col-md-6 {{ $errors->has('send_mobile') ? 'has-error' : '' }}">
                            <small>Sender mobile*</small>
                            <input type="text" name="send_mobile" class="input-group form-control" placeholder="MOBILE NUMBER*" style="height:45px;" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 {{ $errors->has('receiver_name') ? 'has-error' : '' }}">
                            <small>Receiver name*</small>
                            <input type="text" name="receiver_name" class="input-group form-control" placeholder="RECEIVER NAME*" style="height:45px;" required>
                        </div>
                        <div class="col-md-6 {{ $errors->has('receiver_mobile') ? 'has-error' : '' }}">
                            <small>Receiver mobile*</small>
                            <input type="text" name="receiver_mobile" class="input-group form-control" placeholder="RECEIVER MOBILE NUMBER*" style="height:45px;" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 {{ $errors->has('id_no') ? 'has-error' : '' }}">
                            <small>Receiver ID NO*</small>
                            <input type="text" name="id_no" class="input-group form-control" placeholder="RECEIVER ID NUMBER*" style="height:45px;" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 {{ $errors->has('destination') ? 'has-error' : '' }}">
                            <select class="form-control" style="height: 45px;" name="destination" id="category">
                                <option selected hidden data-default disabled>CHOOSE DESTINATION</option>
                                {{-- @foreach($dest as $sp)
                                <option value="{{$sp->id}}">{{$sp->name}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 {{ $errors->has('size') ? 'has-error' : '' }}">
                            <select class="form-control" style="height: 45px;" name="size" id="size_sub_category">
                                <option selected hidden data-default disabled>CHOOSE SIZE/CAPACITY</option>
                            </select>
                        </div>
                        <div class=" col-md-6 {{ $errors->has('service_provider_amount') ? 'has-error' : '' }}">
                            <input type="text" name="service_provider_amount" id="price_sub_category" class="input-group form-control" style="height:45px;" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 {{ $errors->has('payment_method') ? 'has-error' : '' }}">
                            <select class="form-control" style="height: 45px;" required name="payment_method">
                                <option selected data-default disabled>CHOOSE PAYMENT METHOD</option>
                                <option value="cash">CASH</option>
                                <option value="mpesa">MPESA</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" style="height: 45px;" required name="status">
                                <option selected data-default disabled>PARCEL PAYMENT</option>
                                <option value="1">PAID</option>
                                <option value="0">PAY ON DELIVERY</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 {{ $errors->has('parcel_description') ? 'has-error' : '' }}">
                            <textarea name="parcel_description" placeholder="DESCRIBE PARCEL" required style="width:100%;height:70px;resize:none;border-radius:10px;"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block" style="height: 45px;" id="add_parcel">ADD PARCEL</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<div class="modal close_modal" id="print_dispatch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <center style="text-transform: uppercase;">Select Destination
                    </center>
                </h4>
            </div>
            <div class="modal-body">
                <form action="{{route('dashboard.print_dropoff')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <select class="form-control" style="height: 50px;" name="drop">
                                <option selected hidden data-default>SELECT DROPOFF</option>
                                {{-- @foreach($dest as $sp)
                                <option value="{{$sp->id}}">{{$sp->name}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="input-group form-control" style="border-radius: 0px; height: 50px;" name="start_d" id="datetimep_one" placeholder="SELECT MIN DATE">
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="input-group form-control" style="border-radius: 0px; height: 50px;" name="end_d" id="datetimep_two" placeholder="SELECT MAX DATE">
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-warning btn-block" style="height:42px;">PRINT</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('plugins/jquery/jquery-3.2.1.min.js') }}"></script>
<script src="{{asset('/datetime/build/jquery.datetimepicker.full.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#datetimep_one').datetimepicker({
            timepicker: false,
            format: "Y-m-d"
        })
        $('#datetimep_two').datetimepicker({
            timepicker: false,
            format: "Y-m-d"
        })
    })
</script>
<script>
    tinymce.init({
        selector: 'textarea',
        menubar: false,
        plugins: 'link code',
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });
</script>
@endsection