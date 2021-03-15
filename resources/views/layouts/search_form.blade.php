<form action="{{ route('independent.search') }}" method="GET">
    @csrf
    <div class="row">
        <div class="col-12 col-md-6 col-lg-3 col-xl-3">
            <div class="form-group">
                <span><i class="fa fa-angle-down"></i></span>
                <select class="form-control" name="departure" required>
                    <option selected hidden data-default disabled>SELECT DEPARTURE</option>
                    {{-- <option>Meru</option> --}}
                    @foreach($uni->unique('departure') as $rou)
                    <option>{{ $rou->departure }}</option>
                    @endforeach
                </select>
            </div>
        </div><!-- end columns -->

        <div class="col-12 col-md-6 col-lg-3 col-xl-3">
            <div class="form-group">
                <span><i class="fa fa-angle-down"></i></span>
                <select class="form-control" name="destination" required>
                    <option selected hidden data-default disabled>SELECT DESTINATION</option>
                    {{-- <option>Nairobi</option> --}}
                    @foreach($uni->unique('destination') as $rou)
                    <option>{{ $rou->destination }}</option>
                    @endforeach
                </select>
            </div>
        </div><!-- end columns -->

        <div class="col-12 col-md-6 col-lg-3 col-xl-3">
            <div class="form-group">
                <span><i class="fa fa-angle-down"></i></span>
                <select class="form-control">
                    <option selected hidden data-default disabled>SELECT SEATERS</option>
                    {{-- <option>10</option> --}}
                    @foreach($uni->unique('seaters') as $rou)
                    <option>{{$rou->seaters }}</option>
                    @endforeach
                </select>
            </div>
        </div><!-- end columns -->

        <div class="col-12 col-md-6 col-lg-3 col-xl-3">
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-lg btn-block">Search Route</button>
            </div>
        </div><!-- end columns -->

        </div><!-- end row -->
</form>