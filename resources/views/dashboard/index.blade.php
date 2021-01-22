@extends('layouts.dashboard.main')
@section('title', 'Dashboard')
@section('body')

<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow">
            <div class="col-md-3 grid-margin stretc-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Bookings</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-12">
                                <h4 class="mb-2 mt-3">3,897</h4>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <span>+3.3%</span>
                                        <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretc-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Parcels</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-12">
                                <h4 class="mb-2 mt-3">2,520</h4>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <span>+3.3%</span>
                                        <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretc-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Fleets</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-12">
                                <h4 class="mb-2 mt-3">35,084</h4>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-danger">
                                        <span>-2.8%</span>
                                        <i data-feather="arrow-down" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretc-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Growth</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-12">
                                <h3 class="mb-2 mt-2">89.87%</h3>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <span>+2.8%</span>
                                        <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- row -->

<div class="row">
    <div class="col-12 col-xl-12 grid-margin stretch-card">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                    <h6 class="card-title mb-0">Revenue</h6>
                </div>
                <div class="flot-wrapper">
                    <div id="flotChart1" class="flot-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- row -->

<div class="row">
    <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Monthly sales</h6>
                </div>
                <div class="monthly-sales-chart-wrapper">
                    <canvas id="monthly-sales-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Bookings/Parcels proportions</h6>
                <canvas id="chartjsPie"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Available Fleets</h6>
                    <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton7">
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="pt-0">Image</th>
                                <th class="pt-0">Product Name</th>
                                <th class="pt-0">Price</th>
                                <th class="pt-0">Compare Price</th>
                                <th class="pt-0">Quantity</th>
                                <th class="pt-0">Unit</th>
                                <th class="pt-0">Available</th>
                                <th class="pt-0">Status</th>
                                <th class="pt-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach($products as $product)
                            <tr>
                                <td>
                                    <img src="{{asset('users_products_images/'.$product->product_image_a)}}" class="rounded-circle wd-35" alt="user">
                                </td>
                                <td>{{$product->product_name}}</td>
                                <td>{{number_format($product->price, 2)}}</td>
                                <td><strike>{{number_format($product->compare_price, 2)}}</strike></td>
                                <td>{{$product->quantity}}</td>
                                <td>{{$product->unit}}</td>
                                <td>{{$product->number}}</td>
                                <td>
                                    @if($product->active == false)
                                    <span class="badge badge-danger">Not Active</span>
                                    @else
                                    <span class="badge badge-success">Active</span>
                                    @endif
                                </td>
                                <td class="form-inline">
                                    @if($product->active == true)
                                    <form action="{{route('user_lock_product', base64_encode($product->id))}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-warning style=" margin:2px;"">Lock</button>
                                    </form>
                                    @else
                                    <form action="{{route('user_unlock_product', base64_encode($product->id))}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-warning" style="margin:2px;">Unlock</button>
                                    </form>
                                    @endif
                                    <a href="{{route('user_get_edit_product', base64_encode($product->id))}}">
                                        <button type="button" style="margin:2px;" class="btn btn-outline-success">Edit</button>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-icon" style="margin:2px;">
                                        <i data-feather="trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection