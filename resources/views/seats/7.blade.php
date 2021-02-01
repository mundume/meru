<div class="col-md-12">
    <div class="plane{{ $errors->has('seat_no' ? 'has-error' : '') }}">
        <small class="text-danger">{{$errors->first('seat_no')}}</small>
        <div class="cockpit">
            <h1>Booked seats</h1>
        </div>
        <ol class="cabin fuselage">
            <li class="row--1">
                <ol class="seats" type="A">
                    <li class="seat">
                        <input type="checkbox" name="seat_no" value="#1" id="#1" class="book_1">
                        <label for="#1">#1</label>
                    </li>
                    <!-- space -->
                    <li class="seat">
                        <input type="checkbox" style="display: none;" disabled id="1D" />
                        <label for="ID" style="display: none;">Occupied</label>
                    </li>

                    <li class="seat">
                        <input type="checkbox" disabled id="1D" />
                        <label for="1D">Occupied</label>
                    </li>
                    <li class="seat">
                        <input type="checkbox" disabled id="1D" />
                        <label for="1D">Occupied</label>
                    </li>
                </ol>
            </li>
            <li class="row--2">
                <ol class="seats" type="A">
                    <li class="seat">
                        <input type="checkbox" name="seat_no" value="#2" id="#2" class="book_2">
                        <label for="#2">#2</label>
                    </li>
                    <!-- space -->
                    <li class="seat">
                        <input type="checkbox" style="display: none;" disabled id="1D" />
                        <label for="ID" style="display: none;">Occupied</label>
                    </li>

                    <li class="seat">
                        <input type="checkbox" disabled id="1D">
                        <label for="#3">#3</label>
                    </li>
                    <li class="seat">
                        <input type="checkbox" name="seat_no" value="#4" id="#4" class="book_4">
                        <label for="#4">#4</label>
                    </li>
                </ol>
            </li>
            <li class="row--3">
                <ol class="seats" type="A">
                    <li class="seat">
                        <input type="checkbox" name="seat_no" value="#5" id="#5" class="book_5">
                        <label for="#5">#5</label>
                    </li>
                    <!-- space -->
                    <li class="seat">
                        <input type="checkbox" style="display: none;" disabled id="1D" />
                        <label for="ID" style="display: none;">Occupied</label>
                    </li>

                    <li class="seat">
                        <input type="checkbox" disabled id="1D">
                        <label for="#6">#6</label>
                    </li>
                    <li class="seat">
                        <input type="checkbox" name="seat_no" value="#7" id="#7" class="book_7">
                        <label for="#7">#7</label>
                    </li>
                </ol>
            </li>
        </ol>
    </div>
</div>