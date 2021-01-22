@extends('layouts.dashboard.main')
@section('title', 'Dashboard')
@section('body')
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-success float-right" data-toggle="modal" data-target="#add_agent"><i data-feather="plus"></i>&nbsp;ADD AGENT</button>
    </div>
</div>

<!-- pop up -->
<div class="modal close_modal" id="add_agent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <b style="text-transform: uppercase;">Add Agent</b>
                </h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.add_agent') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label>First Name*</label>
                            <input type="text" name="fname" {{ $errors->has('fname') ? 'has-error' : '' }} required style="height:50px;" class="form-control" placeholder="First Name*">
                            <small class="text-danger">{{$errors->first('fname')}}</small>
                        </div>                        
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label>Last Name*</label>
                            <input type="text" name="lname" {{ $errors->has('lname') ? 'has-error' : '' }} required style="height:50px;" class="form-control" placeholder="Last Name*">
                            <small class="text-danger">{{$errors->first('lname')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label>Agency Name*</label>
                            <input type="text" {{ $errors->has('c_name') ? 'has-error' : '' }} name="c_name" required style="height:50px;" class="form-control" value="{{ auth()->user()->c_name }}">
                            <small class="text-danger">{{$errors->first('c_name')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label>Agency Mobile*</label>
                            <input type="text" {{ $errors->has('mobile') ? 'has-error' : '' }} name="mobile" required style="height:50px;" class="form-control" placeholder="Mobile*">
                            <small class="text-danger">{{$errors->first('mobile')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label>Office Mobile*</label>
                            <input type="text" {{ $errors->has('c_mobile') ? 'has-error' : '' }} name="c_mobile" required style="height:50px;" class="form-control" placeholder="Mobile*">
                            <small class="text-danger">{{$errors->first('c_mobile')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label>ID Number*</label>
                            <input type="text" name="id_no" {{ $errors->has('id_no') ? 'has-error' : '' }} required style="height:50px;" class="form-control" placeholder="ID Number*">
                            <small class="text-danger">{{$errors->first('id_no')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label>Email Address*</label>
                            <input type="text" name="email" {{ $errors->has('email') ? 'has-error' : '' }} required style="height:50px;" class="form-control" placeholder="Email Address*">
                            <small class="text-danger">{{$errors->first('email')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Select Role</label>
                            <select class="js-example-basic-single w-100 @error('role') is-invalid @enderror" data-width=" 100%" name="role">
                                <option disabled>Select Role</option>
                                <option value="0">Booking & Courier</option>
                                <option value="1">Courier Only</option>
                            </select>
                            @error('role')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success btn-block" style="height: 42px;">ADD AGENT</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
@endsection