@extends('layouts.dashboard.main')
@section('title', 'Peak & Off-peaks')
@section('body')
<link rel="stylesheet" type="text/css" href="{{asset('/datetime/jquery.datetimepicker.css')}}" />
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-success float-right" type="button" data-toggle="modal" data-target="#add_peak" style="text-transform: uppercase;border-radius: 0px;">
            <i data-feather="plus" class="icon-sm"></i>&nbsp;ADD PEAK
        </button>
    </div>
</div>
<br>
@foreach($data as $header)
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0" style="background-color: #183947;color:white;padding:5px;">
                        {{ $header['categories'] }}
                    </h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="pt-0">#</th>
                                <th class="pt-0">Route</th>
                                <th class="pt-0">Date</th>
                                <th class="pt-0">Off Peak Amount</th>
                                <th class="pt-0">Peak Amount</th>
                                <th class="pt-0">Fleet ID</th>
                                <th class="pt-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($header['calendar'] as $loc)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $loc->name }}</td>
                                <td>{{$loc->date}}</td>
                                <td>{{number_format($loc->off_peak, 2)}}</td>
                                <td>{{number_format($loc->amount, 2)}}</td>
                                <td>{{$loc->fleet_unique}}</td>
                                <td class="form-inline float-right">
                                    <button class="btn btn-outline-success" data-toggle="modal" data-target="#edit_peak-{{$loc->id}}" style="margin:2px;">
                                        <i data-feather="edit" class="icon-sm"></i>
                                    </button>
                                    <form action="{{route('dashboard.delete_peak', base64_encode($loc->id))}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i data-feather="trash" class="icon-sm"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <div class="modal close_modal" id="edit_peak-{{$loc->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content" style="border-radius:0px;">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">
                                                <center style="text-transform: uppercase;">
                                                    <b>Edit Peak</b>
                                                </center>
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('dashboard.edit_peak', base64_encode($loc->id))}}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                                        <input type="text" name="date" value="{{ $loc->date }}" style="border-radius: 0px;height:50px;" id="datee" required class="form-control" readonly>
                                                        <small class="text-danger">{{$errors->first('date')}}</small>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                                        <input type="text" name="amount" style="border-radius: 0px;height:50px;" required class="form-control" value="{{ $loc->amount }}">
                                                        <small class="text-danger">{{$errors->first('amount')}}</small>
                                                    </div>
                                                </div>
                                                <br>
                                                <button type="submit" class="btn btn-warning btn-block">EDIT
                                                    PEAK</button>
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
<br>
@endforeach

<!-- pop up -->
<div class="modal close_modal" id="add_peak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <center style="text-transform: uppercase;"><b>Add Peak</b>
                    </center>
                </h4>
            </div>
            <div class="modal-body">
                <form action="{{route('dashboard.add_peak')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <select class="form-control" name="category_id" style="border-radius: 0px;height:50px;" required>
                                <option selected data-default disabled>SELECT SEASON
                                </option>
                                @foreach($category as $cat)
                                <option value="{{ $cat->id }}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <select class="form-control" style="height: 45px;text-transform: uppercase;" name="fleet_id" required>
                                <option selected data-default disabled>CHOOSE FLEET
                                </option>
                                @foreach($route as $sp)
                                <option value="{{$sp->id}}">{{$sp->departure}}
                                    ({{ substr(strtoupper($sp->group), 0, 5) }}) ~
                                    {{$sp->destination}} ({{ $sp->seaters }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <input type="text" name="date" placeholder="DATE" style="border-radius: 0px;height:50px;" id="date" required class="form-control" readonly>
                            <small class="text-danger">{{$errors->first('date')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <input type="text" name="amount" style="border-radius: 0px;height:50px;" required class="form-control" placeholder="AMOUNT TO BE PAID">
                            <small class="text-danger">{{$errors->first('amount')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <code>Ignore if not locking fleet at date above.*</code>
                            <select class="form-control" name="lock" style="border-radius: 0px;height:50px;">
                                <option selected data-default disabled>LOCK FLEET
                                </option>
                                <option value="1">LOCK</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-warning btn-block" style="height: 42px;">ADD PEAK</button>
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
<script>
    $(document).ready(function () {
        $('#date').datetimepicker({
            datepicker: true,
            timepicker: false,
            format: 'Y-m-d'
        })
        $('#datee').datetimepicker({
            datepicker: true,
            timepicker: false,
            format: 'Y-m-d'
        })
    })
</script>
@endsection