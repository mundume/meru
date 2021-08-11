@extends('layouts.dashboard.main')
@section('title', 'Wallet')
@section('body')
<link rel="stylesheet" type="text/css" href="{{asset('/datetime/jquery.datetimepicker.css')}}" />
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <form action="{{ route('dashboard.filter_wallet') }}" class="form-inline float-right" method="POST">
            @csrf
            {{-- <select class="form-control" name="agent" style="margin:2px;height:42px;" required>
                <option selected data-default disabled>SELECT AGENT
                </option>
                @foreach($agents as $item)
                <option>{{ @$item->user->fname }} {{ @$item->user->lname }}</option>
            @endforeach
            </select> --}}
            <input type="text" name="date" id="date" class="form-control" style="margin:2px;height: 42px;" placeholder="SELECT DATE">
            <button class="btn btn-success" style="height: 40px;margin:2px;" type="submit"><i data-feather="search" class="icon-sm"></i></button>
        </form>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Payments ({{ $payments->count() }})</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="walletTable">
                        <thead>
                            <tr>
                                <th>Ticket/Parcel</th>
                                <th>Date Paid</th>
                                <th>Description</th>
                                <th>Receipt NO</th>
                                <th>Amount</th>
                                <th>Payer</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $item)
                            <tr>
                                <td>{{ $item->ticket_no }}</td>
                                <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                <td>{{ $item->ResultDesc }}</td>
                                <td>{{ $item->mpesaReceiptNumber }}</td>
                                <td>{{ number_format($item->amount, 2) }}</td>
                                <td>{{ $item->phoneNumber }}</td>
                                <td>{{ $item->MerchantRequestID  }}</td>
                                <td>
                                    <button class="btn btn-outline-danger btn-xs" style="margin:1px;" disabled>
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
@endsection
@section('scripts')
<script src="{{ asset('plugins/jquery/jquery-3.2.1.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#date').datetimepicker({
            timepicker: false,
            datepicker: true,
            format: 'Y-m-d'
        })
    })
</script>
<script>
    $(document).ready(function () {
        $('#walletTable').DataTable({
            "drawCallback": function (settings) {
        feather.replace()
        }
        })
    });
</script>
@endsection