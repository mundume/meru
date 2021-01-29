@extends('layouts.dashboard.main')
@section('title', 'Preview')
@section('body')
<div class="row">
    <div class="col-md-12">
        <a href="{{ url()->previous() }}" class="btn btn-outline-warning float-right">
            Go Back
        </a>
    </div>
</div>
<br>
@foreach($prov as $pro)
<div class="row">
    <div class="col-md-4">
        <center>
            <button class="btn btn-info btn-block" style="text-transform: uppercase;border-radius: 0px;">Courier
                Name</button>
            <br>
            <h4>
                {{$pro->c_name}}
            </h4>
        </center>
    </div>
    <div class="col-md-8">
        @foreach($pro->dropoff as $data)
        <button class="btn btn-info btn-block" style="text-transform: uppercase;border-radius: 0px;">{{@$data->office_route}}</button>
        <br>
        @endforeach
    </div>
</div>
@endforeach
<br>
@foreach($charge as $item)
<div class="row">
    <div class="col-md-4">
        <button class="btn btn-info btn-block" style="text-transform: uppercase;border-radius: 0px;">
            {{$item->name}}
        </button>
    </div>
    <div class="col-md-4">
        <button class="btn btn-info btn-block" style="text-transform: uppercase;border-radius: 0px;">KSh&nbsp;{{$item->price}}</button>
    </div>
    <div class="col-md-4">
        <button class="btn btn-info btn-block" style="text-transform: uppercase;border-radius: 0px;">{{@$item->dropoff->office_route}}</button>
    </div>
</div>
<br>
@endforeach
@endsection