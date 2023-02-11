<style>
    form{
        display: block;
        margin:auto;
        text-align:center;
        background:white;
        border:none;
        border-radius: 10px;
        outline:none;
        padding: 20px;
        
    }
   

</style>

<form action="{{ route('independent.search') }}" method="GET" class="tw-m-5 tw-h-96 tw-w-[90%] tw-bg-gray-900">
    <div class="tw-flex tw-justify-between tw-flex-col tw-p-1 tw-shadow-2xl">
        <div class="tw-pt-5">
            <div class="">
              
                <select class="tw-py-4 tw-px-4 tw-rounded tw-mb-5 tw-w-full tw-outline-none tw-border " name="departure" required>
                    <option  selected disabled>Select Departure</option>
                    {{-- <option>Meru</option> --}}
                    @foreach($uni->unique('departure') as $rou)
                    <option>{{ $rou->departure }}</option>
                    @endforeach
                </select>
            </div>
        </div><!-- end columns -->

        <div class="">
            <div class="">
                
                <select class="tw-py-4 tw-px-4 tw-rounded tw-text-gray-900 tw-border-2 tw-mb-5 tw-w-full tw-outline-none " name="destination" required>
                    <option selected hidden data-default disabled>Select Destination</option>
                    {{-- <option>Nairobi</option> --}}
                    @foreach($uni->unique('destination') as $rou)
                    <option>{{ $rou->destination }}</option>
                    @endforeach
                </select>
            </div>
        </div><!-- end columns -->

        <div class="">
            <div class="">
              
                <select class="tw-py-4 tw-px-4 tw-rounded tw-text-gray-900 tw-border-2 tw-mb-5 tw-w-full tw-outline-none "  >
                    <option selected  disabled>Select Seaters</option>
                    {{-- <option>10</option> --}}
                    @foreach($uni->unique('seaters') as $rou)
                    <option>{{$rou->seaters }}</option>
                    @endforeach
                </select>
            </div>
        </div><!-- end columns -->

        <div class>
            <div class="">
                <button type="submit" class="py-2 m-2 tw-px-4 hover:tw-bg-transparent button tw-font-bold tw-p-2 tw-border tw-text-transparent tw-bg-clip-text tw-bg-gradient-to-r tw-from-amber-500 tw-to-pink-500 tw-font-sans ">Search </button>
            </div>
        </div><!-- end columns -->

        </div><!-- end row -->
</form>

