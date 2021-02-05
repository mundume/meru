<form action="{{ route('independent.search') }}" method="GET" class="form-box">
    @csrf
    <div class="row">
        <div class="col-md-12">
            SEARCH ROUTE
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <select class="form-control" name="seaters" required>
                <option selected hidden data-default disabled>SELECT SEATERS</option>
                @foreach($uni->unique('seaters') as $rou)
                <option>{{$rou->seaters }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <br>
    <div class="form-group row">
        <div class="col-md-6 mb-3 mb-lg-0">
            <select class="form-control" name="departure" required>
                <option selected hidden data-default disabled>DEPARTURE</option>
                @foreach($uni->unique('departure') as $rou)
                <option>{{ $rou->departure }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <select class="form-control" name="destination" required>
                <option selected hidden data-default disabled>DESTINATION</option>
                @foreach($uni->unique('destination') as $rou)
                <option>{{ $rou->destination }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary btn-pill btn-block">SEARCH ROUTE</button>
        </div>
    </div>
</form>