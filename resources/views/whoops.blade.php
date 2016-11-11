@extends('layouts.bare')

@section('css')
@parent
<style type="text/css">
.error {
  margin: 0 auto;
  text-align: center;
}

.error-code {
  bottom: 60%;
  color: #2d353c;
  font-size: 96px;
  line-height: 100px;
}

.error-desc {
  font-size: 12px;
  color: #647788;
}

.m-b-10 {
  margin-bottom: 10px!important;
}

.m-b-20 {
  margin-bottom: 20px!important;
}

.m-t-20 {
  margin-top: 20px!important;
}
</style>
@endsection

@section('content')
<div class="container">

    <div class="error">
    <div class="error-code m-b-10 m-t-20">Whoops <i class="fa fa-warning"></i></div>
        <h3 class="font-bold">Something went wrong...</h3>

        <div class="error-desc">
            Sorry, but something made our server angry. <br/>
            Try refreshing the page or click the button below to go back to the Homepage.
            <div>
                <a class=" login-detail-panel-button btn" href="/">
                    <i class="fa fa-arrow-left"></i>
                    Let's move!
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@push('footer_scripts')
{!! TidioChat::js() !!}
@endpush