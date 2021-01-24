@extends('layouts.dashboard.main')
@section('title', 'Edit Routes')
<link rel="stylesheet" type="text/css" href="{{asset('/datetime/jquery.datetimepicker.css')}}" />
@section('body')
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('dashboard.edit_route_post', base64_encode($route->id)) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <legend>
                        <h6 style="text-transform: uppercase;">Basic Information</h6>
                    </legend>
                    <div class="row">
                        <div class="col-md-6 {{$errors->has('group') ? 'has-error' : ''}}">
                            <small>Name *</small>
                            <input type="text" name="group" style="height:42px;" value="{{ Auth::user()->c_name }}" required class="form-control">
                            <small class="text-danger">{{$errors->first('group')}}</small>
                        </div>
                        <div class="col-md-6 {{$errors->has('amount') ? 'has-error' : ''}}">
                            <small>Amount*</small>
                            <input type="text" name="amount" style="height:42px;" value="{{ $route->amount }}" required class="form-control">
                            <small class="text-danger">{{$errors->first('amount')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 {{$errors->has('seaters') ? 'has-error' : ''}}">
                            <small>Seaters*</small>
                            <input type="number" name="seaters" value="{{ $route->seaters }}" style="height:42px;" required class="form-control">
                            <small class="text-danger">{{$errors->first('seaters')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 {{$errors->has('departure') ? 'has-error' : ''}}">
                            <small>Departure*</small>
                            <input type="text" name="departure" value="{{ $route->departure }}" style="height:42px;" required class="form-control">
                            <small class="text-danger">{{$errors->first('departure')}}</small>
                        </div>
                        <div class="col-md-6 {{$errors->has('destination') ? 'has-error' : ''}}">
                            <small>Destination*</small>
                            <input type="text" name="destination" value="{{ $route->destination }}" style="height:42px;" required class="form-control">
                            <small class="text-danger">{{$errors->first('destination')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 {{$errors->has('mobile') ? 'has-error' : ''}}">
                            <small>Contact *</small>
                            <input type="text" name="mobile" style="height:42px;" value="{{ $route->mobile }}" required class="form-control">
                            <small class="text-danger">{{$errors->first('mobile')}}</small>
                        </div>
                        <div class="col-md-6">
                            <small>Re-assign Agent* <b>{{ @$agent->user->first_name }} {{ @$agent->user->last_name }}</b></small>
                            <select class="form-control border-radius" style="height: 45px;text-transform: uppercase;" name="agent">
                                <option selected data-default disabled>Re-assign Agent</option>
                                <option value="ignore">HEAD OFFICE</option>
                                @foreach($agents as $sp)
                                <option value="{{ @$sp->user_id }}">{{@$sp->user->fname}}
                                    {{ @$sp->user->lname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 {{$errors->has('location') ? 'has-error' : ''}}">
                            <small>Office Location*</small>
                            <textarea name="location" required>{{ $route->location }}</textarea>
                            <small class="text-danger">{{$errors->first('location')}}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <legend>
                        <h6 style="text-transform: uppercase;">Pick up and time information</h6>
                    </legend>
                    <small>First Departure</small>
                    <div class="row">
                        <div class="col-md-6 {{$errors->has('depart1') ? 'has-error' : ''}}">
                            <input type="text" name="depart1" style="height:42px;" value="{{ $route->depart1 }}" class="form-control" id="depart1" required>
                            <small class="text-danger">{{$errors->first('depart1')}}</small>
                        </div>
                        <div class="col-md-6 {{$errors->has('arriv1') ? 'has-error' : ''}}">
                            <input type="text" name="arriv1" style="height:42px;" value="{{ $route->arriv1 }}" class="form-control" id="arriv1" required>
                            <small class="text-danger">{{$errors->first('arriv1')}}</small>
                        </div>
                    </div>
                    <hr>
                    <small>Second Departure</small>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="depart2" style="height:42px;" value="{{ $route->depart2 }}" class="form-control" id="depart2">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="arriv2" style="height:42px;" value="{{ $route->arriv2 }}" class="form-control" id="arriv2">
                        </div>
                    </div>
                    <hr>
                    <small>Third Departure</small>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="depart3" style="height:42px;" value="{{ $route->depart3 }}" class="form-control" id="depart3">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="arriv3" style="height:42px;" value="{{ $route->arriv3 }}" class="form-control" id="arriv3">
                        </div>
                    </div>
                    <hr>
                    <small>Fouth Departure</small>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="depart4" style="height:42px;" value="{{ $route->depart4 }}" class="form-control" id="depart4">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="arriv4" style="height:42px;" value="{{ $route->arriv4 }}" class="form-control" id="arriv4">
                        </div>
                    </div>
                    <br>
                    <small>Pickups</small>
                    <div class="row">
                        <div class="col-md-9" id="dynamic_field">
                            @foreach($route->pick_up as $row)
                            <div class="form-inline" id="cec_">
                                <input type="text" name="pick_up[]" value="{{$row}}" class="form-control" id="my_value" style="height:42px;width:100%;" />
                                {{-- <button id="looped" type="button" class="btn btn-danger pull-right">X</button> --}}
                            </div>
                            <br>
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <button type="button" name="add" id="add" class="btn btn-success">
                                <i data-feather="plus"></i>
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-success btn-block" type="submit" style="height: 42px;">EDIT ROUTE</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('plugins/jquery/jquery-3.2.1.min.js') }}"></script>
<script src="{{asset('/datetime/build/jquery.datetimepicker.full.min.js')}}"></script>
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
<script>
    $(document).ready(function () {
        var i = 1;
        $('#add').click(function () {
            i++;
            $('#dynamic_field').append(
                '<div id="row' + i + '"><div class="form-inline">' +
                '<br>' +
                '<input type="text" name="pick_up[]" placeholder="Add Pick Up Points (Optional)" ' +
                ' style="width:80%;height:45px;" class="form-control" />' +
                '&nbsp;' +
                '<button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove pull-right">X</button>' +
                '</div></div><br>');
        });
        $(document).on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#depart1').datetimepicker({
            timepicker: true,
            datepicker: false,
            format: 'H:i'
        })
        $('#depart2').datetimepicker({
            timepicker: true,
            datepicker: false,
            format: 'H:i'
        })
        $('#depart3').datetimepicker({
            timepicker: true,
            datepicker: false,
            format: 'H:i'
        })
        $('#depart4').datetimepicker({
            timepicker: true,
            datepicker: false,
            format: 'H:i'
        })
        $('#arriv1').datetimepicker({
            timepicker: true,
            datepicker: false,
            format: 'H:i'
        })
        $('#arriv2').datetimepicker({
            timepicker: true,
            datepicker: false,
            format: 'H:i'
        })
        $('#arriv3').datetimepicker({
            timepicker: true,
            datepicker: false,
            format: 'H:i'
        })
        $('#arriv4').datetimepicker({
            timepicker: true,
            datepicker: false,
            format: 'H:i'
        })
    })
</script>
@endsection
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
