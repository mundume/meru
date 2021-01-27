@extends('layouts.dashboard.main')
@section('title', 'Generate Ticket 7 Seaters')
<link rel="stylesheet" href="{{ asset('css/frame.css') }}">
@section('body')
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-outline-success">Point A ~ Point B | Booking Office</button>
        <a href="{{ url()->previous() }}" class="btn btn-outline-warning"><i data-feather="arrow-left" class="icon-sm"></i>Go Back</a>
        <button class="btn btn-success float-right" type="button" data-toggle="modal" data-target="#generate_ticket">Generate Ticket&nbsp;<i data-feather="map" class="icon-sm"></i></button>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-4">
        <div class="row">
            @include('seats.7')
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-success btn-block" type="submit" style="text-transform:uppercase;">
                    Dispatch fleet
                </button>
                <br>
                <button class="btn btn-warning btn-block" type="submit" style="text-transform:uppercase;">
                    Print Last Dispatch
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-lg-12 col-xl-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline mb-2">
                            <h6 class="card-title mb-0">Online Booked Seats</h6>
                            <br>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="pt-0">#</th>
                                        <th class="pt-0">Name</th>
                                        <th class="pt-0">ID Number</th>
                                        <th class="pt-0">Ticker No</th>
                                        <th class="pt-0">Route</th>
                                        <th class="pt-0">Amount</th>
                                        <th class="pt-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr></tr>
                                </tbody>
                            </table>
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
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="pt-0">#</th>
                                        <th class="pt-0">Name</th>
                                        <th class="pt-0">ID Number</th>
                                        <th class="pt-0">Ticker No</th>
                                        <th class="pt-0">Route</th>
                                        <th class="pt-0">Amount</th>
                                        <th class="pt-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- pop up -->
<div class="modal close_modal" id="generate_ticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <center style="text-transform: uppercase;">Generate Ticket
                    </center>
                </h4>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="#" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <small>Name*</small>
                            <input type="text" name="fullname" required style="height:42px;" class="form-control" placeholder="Name *">
                        </div>
                        <br class="hidden-lg hidden-md">
                        <div class="col-md-6">
                            <small>ID Number*</small>
                            <input type="text" name="id_no" required style="height:42px;" class="form-control" placeholder="ID Number *">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <small>Mobile*</small>
                            <input type="text" name="mobile" required class="form-control" style="height:42px;" placeholder="0712345678 *">
                        </div>
                        <br class="hidden-lg hidden-md">
                        <div class="col-md-6">
                            <small>Amount</small>
                            <input type="text" style="height:42px;" class="form-control" name="amount" required value="{{ $route->amount }}">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-control" style="height: 42px;" name="departure">
                                <option>{{$route->departure}}</option>
                            </select>
                        </div>
                        <br class="hidden-lg hidden-md">
                        <div class="col-md-6">
                            <select class="form-control" style="height: 42px;" name="destination">
                                <option>{{$route->destination}}</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <select class="form-control" required style="height: 42px;" name="payment_method">
                        <option selected data-default disabled>CHOOSE PAYMENT METHOD</option>
                        <option value="cash">CASH</option>
                        <option value="mpesa">MPESA</option>
                    </select>
                    <br>
                    <small style="color:red;text-transform:uppercase;">
                        *Ignore travel date if customer is travelling
                        now.
                    </small>
                    <br>
                    <div id="show_time">
                        <input type="text" name="travel_date" placeholder="TRAVEL DATE" style="border-radius: 0px;height:42px;" id="get_date" class="form-control" onfocus="(this.type='date')">
                    </div>
                    <br>
                    <div class="row" id="select_time" hidden>
                        <div class="col-md-10 col-sm-10 col-xs-10">
                            <select class="form-control" name="time" id="cecelia" style="height:42px;">
                                <option selected data-default disabled>SELECT TIME</option>
                                <option>{{$route->depart1}}</option>
                                <option>{{$route->depart2}}</option>
                                <option>{{$route->depart3}}</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <center>
                                <button class="btn btn-danger btn-block" style="height: 42px;" type="button" id="clear_select">
                                    <i data-feather="trash" stle="color:red;"></i>
                                </button>
                            </center>
                        </div>
                        <small class="text-danger">{{$errors->first('time')}}</small>
                    </div>
                    <br>
                    {{-- <input name="group" hidden value="{{$route->group}}">
                    <input name="seaters" hidden value="{{ $route->seaters }}">
                    <input name="fleet_unique" hidden value="{{$route->fleet_unique}}"> --}}
                    <div class="row">
                        {{-- @include('seats.7_1') --}}
                    </div>
                    <button type="submit" class="btn btn-success btn-block" style="height: 42px;">CREATE TICKET</button>
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
        $('#show_time').click(function () {
            $('#select_time').removeAttr('hidden')
        })
        $('#clear_select').click(function () {
            $('#cecelia').val('').trigger('change')
            $('input[type=date]').val('');
            $('#select_time').attr("hidden", "hidden")
        })
    })
</script>
@if (count($errors) > 0)
<script>
    $(document).ready(function () {
        $('#generate_ticket').modal('show');
    });
</script>
@endif
@endsection