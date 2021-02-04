@extends('layouts.dashboard.main')
@section('title', 'Agents')
@section('body')
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-success float-right" style="margin:2px;" data-toggle="modal" data-target="#add_agent">
            <i data-feather="plus" class="icon-sm"></i>&nbsp;ADD AGENT
        </button>
        <button class="btn btn-warning float-right" style="margin:2px;" data-toggle="modal" data-target="#topup_agent">
            <i data-feather="dollar-sign" class="icon-sm"></i>&nbsp;CREDIT AGENT ACCOUNT
        </button>
        </div>
        </div>
        @if(auth()->user()->role_id == 1)
        <br>
        <div class="row">
            <div class="col-lg-12 col-xl-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline mb-2">
                            <h6 class="card-title mb-0">Administrators</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="pt-0">#</th>
                                            <th class="pt-0">Name</th>
                                            {{-- <th class="pt-0">ID</th> --}}
                                            <th class="pt-0">Email</th>
                                            <th class="pt-0">Mobile</th>
                                            <th class="pt-0">Office Mobile</th>
                                            {{-- <th class="pt-0">Pass Code</th> --}}
                                            <th class="pt-0"></th>
                                            {{-- <th class="pt-0">Office</th> --}}
                                            <th class="pt-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($admins as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{$user->fname}}</td>
                                            {{-- <td>{{ $user->user->id_no }}</td> --}}
                                            <td><code>{{ $user->email }}</code></td>
                                            <td>{{ $user->mobile }}</td>
                                            <td>{{ $user->c_mobile }}</td>
                                            {{-- <td>{{ $user->pass_code }}</td> --}}
                                            <td>
                                                @if($user->suspend == null)
                                                <span class="badge badge-success">Active</span>
                                                @else
                                                <span class="badge badge-danger">Not Active</span>
                                                @endif
                                            </td>
                                            {{-- <td>{{ @$user->dropoff->office_name }}</td> --}}
                                            <td class="form-inline">
                                                @if($user->role_id == 0)
                                                @if($user->suspend == null)
                                                <form action="{{route('dashboard.agent_lock', base64_encode($user->id))}}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-warning" style="margin:2px;">
                                                        <i data-feather="lock" class="icon-sm"></i>
                                                    </button>
                                                </form>
                                                @else
                                                <form action="{{route('dashboard.agent_unlock', base64_encode($user->id))}}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success" style="margin:2px;">
                                                        <i data-feather="unlock" class="icon-sm"></i>
                                                    </button>
                                                </form>
                                                @endif
                                                @endif
                                                <button type="button" style="margin:2px;" class="btn btn-outline-success">
                                                    <i data-feather="edit" class="icon-sm"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-danger" style="margin:2px;">
                                                    <i data-feather="trash" class="icon-sm"></i>
                                                </button>
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
                            @endif
                            <br>
                            <div class="row">
                                <div class="col-lg-12 col-xl-12 stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-baseline mb-2">
                            <h6 class="card-title mb-0">Agents</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="pt-0">#</th>
                                        <th class="pt-0">Name</th>
                                        {{-- <th class="pt-0">ID</th> --}}
                                        <th class="pt-0">Email</th>
                                        <th class="pt-0">Mobile</th>
                                        <th class="pt-0">Office Mobile</th>
                                        <th class="pt-0">Pass Code</th>
                                        <th class="pt-0"></th>
                                        <th class="pt-0">Office</th>
                                        <th class="pt-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($agents as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$user->user->fname}}</td>
                                        {{-- <td>{{ $user->user->id_no }}</td> --}}
                                        <td><code>{{ $user->user->email }}</code></td>
                                        <td>{{ $user->user->mobile }}</td>
                                        <td>{{ $user->user->c_mobile }}</td>
                                        <td>{{ $user->pass_code }}</td>
                                        <td>
                                            @if($user->user->suspend == null)
                                            <span class="badge badge-success">Active</span>                                            
                                            @else
                                            <span class="badge badge-danger">Not Active</span>
                                            @endif
                                        </td>
                                        <td>{{ substr(@$user->dropoff->office_name,0,10) }}..</td>
                                        <td class="form-inline">
                                            @if($user->user->suspend == null)
                                            <form action="{{route('dashboard.agent_lock', base64_encode($user->user->id))}}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-warning" style="margin:2px;">
                                                    <i data-feather="lock" class="icon-sm"></i>
                                                </button>
                                            </form>
                                            @else
                                            <form action="{{route('dashboard.agent_unlock', base64_encode($user->user->id))}}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success" style="margin:2px;">
                                                    <i data-feather="unlock" class="icon-sm"></i>
                                                </button>
                                            </form>
                                            @endif
                                            <button type="button" style="margin:2px;" class="btn btn-outline-success" data-toggle="modal" data-target="#edit_agent">
                                                <i data-feather="edit" class="icon-sm"></i>
                                            </button>
                                            {{-- <form action="{{ route('dashboard.delete_user', base64_encode($user->user->id)) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger" style="margin:2px;">
                                                <i data-feather="trash" class="icon-sm"></i>
                                            </button>
                                            </form> --}}
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
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Agents Topups</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="pt-0">#</th>
                                <th class="pt-0">Name</th>
                                <th class="pt-0">ID</th>
                                <th class="pt-0">Amount</th>
                                <th class="pt-0">Mobile</th>
                                <th class="pt-0"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topups as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$user->user->fname}} {{ $user->user->lname }}</td>
                                <td>{{ $user->user->id_no }}</td>
                                <td>{{ number_format($user->amount, 2) }}</td>
                                <td>{{ $user->user->mobile }}</td>
                                <td class="float-right">
                                    <button type="button" class="btn btn-outline-danger" style="margin:2px;">
                                        <i data-feather="trash" class="icon-sm"></i>
                                    </button>
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

<!-- pop up -->
<div class="modal close_modal" id="add_agent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="text-transform: uppercase;">
                    Add Agent
                </h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.add_agent') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label>First Name*</label>
                            <input type="text" name="fname" {{ $errors->has('fname') ? 'has-error' : '' }} required style="height:42px;" class="form-control" placeholder="First Name*">
                            <small class="text-danger">{{$errors->first('fname')}}</small>
                        </div>  
                        <div class="col-md-6">
                            <label>Last Name*</label>
                            <input type="text" name="lname" {{ $errors->has('lname') ? 'has-error' : '' }} required style="height:42px;" class="form-control" placeholder="Last Name*">
                            <small class="text-danger">{{$errors->first('lname')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label>Agency Name*</label>
                            <input type="text" {{ $errors->has('c_name') ? 'has-error' : '' }} name="c_name" required style="height:42px;" class="form-control" value="{{ auth()->user()->c_name }}">
                            <small class="text-danger">{{$errors->first('c_name')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Agency Mobile*</label>
                            <input type="text" {{ $errors->has('mobile') ? 'has-error' : '' }} name="mobile" required style="height:42px;" class="form-control" placeholder="Mobile*">
                            <small class="text-danger">{{$errors->first('mobile')}}</small>
                        </div>
                        <div class="col-md-6">
                            <label>Office Mobile*</label>
                            <input type="text" {{ $errors->has('c_mobile') ? 'has-error' : '' }} name="c_mobile" required style="height:42px;" class="form-control" placeholder="Mobile*">
                            <small class="text-danger">{{$errors->first('c_mobile')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label>ID Number*</label>
                            <input type="text" name="id_no" {{ $errors->has('id_no') ? 'has-error' : '' }} required style="height:42px;" class="form-control" placeholder="ID Number*">
                            <small class="text-danger">{{$errors->first('id_no')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <label>Email Address*</label>
                            <input type="text" name="email" {{ $errors->has('email') ? 'has-error' : '' }} required style="height:42px;" class="form-control" placeholder="Email Address*">
                            <small class="text-danger">{{$errors->first('email')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Select Role</label>
                            <select class="js-example-basic-single w-100 @error('role') is-invalid @enderror" style="height: 42px;" name="role">
                                <option selected hidden data-default disabled>Select Role</option>
                                <option value="0">Booking & Courier</option>
                                <option value="1">Courier Only</option>
                                @if(auth()->user()->role_id == 1)
                                <option value="2">Admin</option>
                                @endif
                            </select>
                            @error('role')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label>Assign Agent Location</label>
                            <select class="form-control" style="height: 42px;" required name="office_name">
                                <option selected data-default disabled>Assign Agent Location</option>
                                @foreach($offices->unique('office_name') as $sp)
                                <option>{{$sp->office_name}}</option>
                                @endforeach
                                @if(auth()->user()->role_id == 1)
                                <option value="admin">Admin</option>
                                @endif
                            </select>
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
<div class="modal close_modal" id="topup_agent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <center style="text-transform: uppercase;">Topup Agent Account
                    </center>
                </h4>
            </div>
            <div class="modal-body">
                <form action="{{route('dashboard.topup_agent')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12 {{ $errors->cood->has('email') ? 'has-error' : '' }}">
                            <select class="form-control" style="height: 42px;" name="email" required>
                                <option selected data-default disabled>CHOOSE AGENT</option>
                                @foreach($agents as $agent)
                                <option>{{$agent->user->email}}</option>
                                @endforeach
                            </select>
                            {{-- <input type="text" {{ $errors->cood->has('email') ? 'has-error' : '' }} name="email" required style="height:42px;" class="form-control" placeholder="Email Address*"> --}}
                            <small class="text-danger">{{$errors->cood->first('email')}}</small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12 {{ $errors->cood->has('amount') ? 'has-error' : '' }}">
                            <input type="number" name="amount" required style="height:42px;" class="form-control" placeholder="Amount*">
                            <small class="text-danger">{{$errors->cood->first('amount')}}</small>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-warning btn-block" style="height:42px;">TOPUP</button>
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
@if (count($errors->cood) > 0)
<script>
    $(document).ready(function () {
        $('#topup_agent').modal('show');
    });
</script>
@endif
@if (count($errors) > 0)
<script>
    $(document).ready(function () {
        $('#add_agent').modal('show');
    });
</script>
@endif
@endsection