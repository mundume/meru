@extends('layouts.dashboard.main')
@section('title', 'Peak & Off-peaks')
@section('body')
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-success" type="button" data-toggle="modal" data-target="#add_peak" style="text-transform: uppercase;border-radius: 0px;">ADD PEAK</button>
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
                            <tr class="info">
                                <th>#</th>
                                <th>Route</th>
                                <th>Date</th>
                                <th>Off Peak Amount</th>
                                <th>Peak Amount</th>
                                <th>Fleet ID</th>
                                <th>Action</th>
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
                                <td class="form-inline">
                                    <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#edit_peak-{{$loc->id}}"><i class="fa fa-edit"></i></button>
                                    <form action="{{route('provider.delete_peak', $loc->id)}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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
                                            <form action="{{route('provider.edit_peak', $loc->id)}}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                                        <input type="text" name="date" value="{{ $loc->date }}" style="border-radius: 0px;height:50px;" id="get_date" required class="form-control" readonly>
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
                                                <button type="submit" class="btn btn-warning">EDIT
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
                            <input type="text" name="date" placeholder="DATE" style="border-radius: 0px;height:50px;" id="get_datee" required class="form-control" readonly>
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
                    <button type="submit" class="btn btn-warning">ADD PEAK</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
@endsection