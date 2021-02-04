@extends('layouts.dashboard.main')
@section('title', 'Parcel Dispatches')
@section('body')
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">All Parcel ({{ $parcels->count() }})</h6>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="agentTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>#/N</th>
                                <th></th>
                                <th>Receiver Name</th>
                                <th>ID</th>
                                <th>Fleet</th>
                                <th>Amount</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($parcels as $item)
                            <tr>
                                <td class="form-inline">
                                    @if($item->progress == 1)
                                    <form action="{{route('dashboard.print_parcel', $item->parcel_no)}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-warning" style="margin:2px;">
                                            <i data-feather="printer" class="icon-sm"></i>
                                        </button>
                                    </form>
                                    @if($item->picked == 0)
                                    <button class="btn btn-outline-success" style="margin:2px;" data-toggle="modal" data-target="#edit_parcel_{{ $item->parcel_no }}">
                                        <i data-feather="edit" class="icon-sm"></i>
                                    </button>
                                    @else
                                    <button class="btn btn-outline-success" style="margin:2px;" disabled>
                                        <i data-feather="edit" class="icon-sm"></i>
                                    </button>
                                    @endif
                                    @else
                                    <form action="{{route('dashboard.progress', $item->id)}}" method="POST">
                                        @csrf
                                        <button class="btn btn-success" style="margin:2px;">
                                            <i data-feather="check" class="icon-sm"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                                <td>{{$item->parcel_no}}</td>
                                <td>
                                    @if($item->is_paid == false)
                                    <span class="badge badge-danger">Not Paid</span>
                                    @else
                                    <span class="badge badge-success">Paid</span>
                                    @endif
                                </td>
                                <td>{{$item->receiver_name}}</td>
                                <td>{{$item->id_no}}</td>
                                <td>{{@$item->fleet->fleet_id}}</td>
                                <td>{{number_format($item->service_provider_amount, 2)}}</td>
                                <td class="form-inline">
                                    <button class="btn btn-outline-info" data-toggle="modal" style="margin:2px;" data-target="#more_info_{{ $item->id }}">
                                        <i data-feather="eye" class="icon-sm"></i>
                                    </button>
                                    @if($item->progress == 1 && $item->picked == 0)
                                    <button class="btn btn-success" data-toggle="modal" style="margin:2px;" data-target="#send_message_{{ $item->id }}">
                                        <i data-feather="message-square" class="icon-sm"></i>
                                    </button>
                                    @endif
                                    @if($item->picked == false)
                                    <form action="{{route('dashboard.picked', $item->id)}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success" style="margin:2px;"><small>confirm</small></button>
                                    </form>
                                    @else
                                    <button type="submit" class="btn btn-danger" style="margin:2px;" disabled>picked</button>
                                    <form action="{{route('dashboard.print_receipt', $item->parcel_no)}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-info" style="margin:2px;"><i data-feather="map" class="icon-sm"></i></button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            <div class="modal close_modal" id="send_message_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content" style="border-radius:0px;">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">
                                                <center style="text-transform: uppercase;">
                                                    Compose Message
                                                    <br>
                                                    <small id="charNum"></small>
                                                </center>
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('dashboard.sms', $item->id)}}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <textarea class="form-control" style="resize: none;" name="message" rows="5" cols="30" maxlength="158" onkeyup="countChar(this)">Dear&nbsp;{{ $item->receiver_name }},&#13;Kindly&nbsp;pick&nbsp;your&nbsp;parcel&nbsp;at&nbsp;our&nbsp;office&nbsp;{{ @$item->dropoff->name }}&#13;Regards&#13;{{ auth()->user()->c_name }}&nbsp;Team</textarea>
                                                </div>
                                                <div class="form-group">
                                                    Recipient:
                                                    <code>{{ $item->receiver_mobile }}</code>
                                                </div>
                                                <button type="submit" class="btn btn-success float-right mb-2">SEND MESSAGE</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal close_modal" id="more_info_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content" style="border-radius:0px;">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">
                                                <center style="text-transform: uppercase;">
                                                    More Parcel Information
                                                </center>
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Sender name <b>{{ $item->sender_name }}</b></p>
                                            <p>Sender mobile <b>{{$item->sender_mobile}}</b></p>
                                            <p>Receiver mobile <b>{{$item->receiver_mobile}}</b></p>
                                            <p>Destination <b>{{@$item->dropoff->office_route}}</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                                            <form action="{{route('dashboard.parcel_assign_fleet', $item->parcel_no)}}" method="POST">
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
                                                <button type="submit" class="btn btn-success btn-block" style="border-radius: 0;height:45px;">ASSIGN FLEET PARCEL</button>
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
@endsection
@section('scripts')
<script src="{{ asset('plugins/jquery/jquery-3.2.1.min.js') }}"></script>
<script>
    function countChar(val) {
        var len = val.value.length;
        $('#charNum').text(len);
    };
</script>
<script>
    $(document).ready(function () {
        $('#agentTable').DataTable()
    });
</script>
@endsection