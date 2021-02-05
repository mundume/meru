@extends('layouts.dashboard.main')
@section('title', 'Reports')
@section('body')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                    <h6 class="card-title mb-0">Parcels</h6>
                </div>
                <div class="flot-wrapper">
                    <canvas id="parcelGraph"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                    <h6 class="card-title mb-0">Bookings</h6>
                </div>
                <div class="flot-wrapper">
                    <canvas id="bookingGraph"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-success float-right" data-toggle="modal" data-target="#testUser">
            <i class="icon-sm" data-feather="plus"></i>&nbsp;Add Receiver
        </button>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">All Receiver</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Date Created</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $customer)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    {{$customer->name}}
                                </td>
                                <td><code>{{ $customer->mobile }}</code></td>
                                <td>{{ $customer->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <form action="{{ route('dashboard.trash_admin', base64_encode($customer->id)) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i data-feather="trash" class="icon-sm"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- pop ups -->
<div class="modal close_modal" id="testUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <center style="text-transform: uppercase;">Add Receiver
                    </center>
                </h4>
            </div>
            <div class="modal-body">
                <form action="{{route('dashboard.add_admin')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="name" {{ $errors->has('name') ? 'has-error' : '' }} required style="height:42px;" class="form-control" placeholder="John Doe *">
                            <small class="text-danger">{{$errors->first('name')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="mobile" {{ $errors->has('mobile') ? 'has-error' : '' }} required style="height:42px;" class="form-control" placeholder="0712345678 *">
                            <small class="text-danger">{{$errors->first('mobile')}}</small>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-warning btn-block" style="height:40px;">ADD CONTACT</button>
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
    $.ajax({
        url: "{{ route('graphs.reporting_parcel') }}",
        type: "GET",
        success: function (result) {
            var obj = jQuery.parseJSON(result)
            var options = {
                type: 'bar',
                data: {
                    labels: obj.label,
                    datasets: obj.datasets
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                reverse: false
                            }
                        }]
                    }
                }
            }
            var ctx = document.getElementById('parcelGraph').getContext('2d')
            new Chart(ctx, options)
        }
    })
</script>
<script>
    $.ajax({
        url: "{{ route('graphs.reporting_booking') }}",
        type: "GET",
        success: function (result) {
            var obj = jQuery.parseJSON(result)
            var options = {
                type: 'bar',
                data: {
                    labels: obj.label,
                    datasets: obj.datasets
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                reverse: false
                            }
                        }]
                    }
                }
            }
            var ctx = document.getElementById('bookingGraph').getContext('2d')
            new Chart(ctx, options)
        }
    })
</script>
@endsection