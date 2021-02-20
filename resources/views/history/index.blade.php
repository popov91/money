@include('layouts.header')
<div class="container" style="margin-top: 20px">
    <div class="row" id="app">
        <div class="col-md-12">
            <result-form
                :valute-list="{{json_encode($valuteList)}}"
            ></result-form>
        </div>
    </div>
</div>
@include('layouts.footer')
