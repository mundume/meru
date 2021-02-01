<div class="col-md-12">
    <div class="plane{{ $errors->has('seat_no' ? 'has-error' : '') }}">
        <small class="text-danger">{{$errors->first('seat_no')}}</small>
        <div class="cockpit">
            <h1>Select a seat</h1>
        </div>
        <ol class="cabin fuselage">
            <li class="row--1" style="width:100%;">
                <ol class="seats" type="A">
                    <li class="seat">
                        <input type="checkbox" name="seat_no" value="#1" id="#1_1" class="book_1_1">
                        <label for="#1_1">#1</label>
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
                        <input type="checkbox" name="seat_no" value="#2" id="#2_1" class="book_2_1">
                        <label for="#2_1">#2</label>
                    </li>
                    <!-- space -->
                    <li class="seat">
                        <input type="checkbox" style="display: none;" disabled id="1D" />
                        <label for="ID" style="display: none;">Occupied</label>
                    </li>
                        <li class="seat">
                        <input type="checkbox" disabled id="1D">
                        <label for="#3_1">#3</label>
                    </li>
                    <li class="seat">
                        <input type="checkbox" name="seat_no" value="#4" id="#4_1" class="book_4_1">
                        <label for="#4_1">#4</label>
                    </li>
                </ol>
            </li>
            <li class="row--3">
                <ol class="seats" type="A">
                    <li class="seat">
                        <input type="checkbox" name="seat_no" value="#5" id="#5_1" class="book_5_1">
                        <label for="#5_1">#5</label>
                    </li>
                    <!-- space -->
                    <li class="seat">
                        <input type="checkbox" style="display: none;" disabled id="1D" />
                        <label for="ID" style="display: none;">Occupied</label>
                        </li>
                        <li class="seat">
                            <input type="checkbox" disabled id="1D">
                        <label for="#6_1">#6</label>
                    </li>
                    <li class="seat">
                        <input type="checkbox" name="seat_no" value="#7" id="#7_1" class="book_7_1">
                        <label for="#7_1">#7</label>
                    </li>
                </ol>
            </li>
        </ol>
    </div>
</div>