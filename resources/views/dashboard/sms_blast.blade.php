@extends('layouts.dashboard.main')
@section('title', 'Sms Blasts')
@section('body')
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>
    <div class="col-md-3">
        <form action="{{route('dashboard.import_contacts', base64_encode(auth()->user()->id))}}" method="POST">
            @csrf
            <button type="submit" class="btn btn-warning btn-block"><i data-feather="download" class="icon-sm"></i>
                IMPORT BOOKING CONTACTS</button>
        </form>
    </div>
    <div class="col-md-3">
        <button type="submit" data-toggle="modal" data-target="#testUser" class="btn btn-success btn-block"><i data-feather="plus" class="icon-sm"></i>
            ADD CONTACT</button>
    </div>
</div>

<br>

<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">All Customers</h6>
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
                            @foreach($customers as $customer)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    {{$customer->name}}
                                </td>
                                <td><code>{{ $customer->mobile }}</code></td>
                                <td>{{ $customer->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <form action="{{ route('dashboard.trash_customer', base64_encode($customer->id)) }}" method="POST">
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

<br>

<div class="row">
    <div class="col-md-12">
        <form action="{{route('dashboard.contacts_delete', base64_encode(auth()->user()->id))}}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger float-right"><i data-feather="trash" class="icon-sm"></i>
                CLEAR CONTACTS</button>
        </form>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-12">

        <form action="{{route('dashboard.send_blast_sms')}}" method="POST">
            @csrf
            <div class="form-group">
                <label>Compose Message:* <b id="charNum"></b></label>
                <textarea class="form-control" style="resize: none;" name="message" rows="5" cols="30" maxlength="158" onkeyup="countChar(this)">Dear&nbsp;valued&nbsp;customer,&nbsp;&#13;Catch&nbsp;early&nbsp;booking&nbsp;at&nbsp;affordable&nbsp;charges.&#13;Call/sms/whatsapp&nbsp;{{ auth()->user()->mobile }}&nbsp;for&nbsp;more&nbsp;details&nbsp;&#13;Regards&#13;{{ auth()->user()->c_name }}&nbsp;Team</textarea>
            </div>
            <button type="submit" class="btn btn-success float-right mb-2">SEND BULK
                SMS</button>
        </form>

    </div>
</div>


<!-- pop ups -->
<div class="modal close_modal" id="testUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <center style="text-transform: uppercase;">Add Customer
                    </center>
                </h4>
            </div>
            <div class="modal-body">
                <form action="{{route('dashboard.add_customer')}}" method="POST">
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
@if (count($errors) > 0)
<script>
    $(document).ready(function () {
        $('#testUser').modal('show');
    });
</script>
@endif
<script>
    function countChar(val) {
        var len = val.value.length;
        $('#charNum').text(len);
    };
</script>
@endsection