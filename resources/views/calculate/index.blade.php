@include('layouts.header')
<div class="container" style="margin-top: 20px">
    <div class="row" id="app">
        <div class="col-md-12">
            <valute-form
                :valutes="{{json_encode($valutes)}}"
            ></valute-form>
        </div>
    </div>
</div>
@include('layouts.footer')
