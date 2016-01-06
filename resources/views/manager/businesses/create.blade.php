@extends('app')

@section('content')
<div class="container">

    {!! Alert::info(trans('manager.businesses.msg.register', ['plan' => trans($plan)])) !!}


    <div class="panel panel-default">

        <div class="panel-heading">{{ trans('manager.businesses.create.title') }}</div>

        <div class="panel-body">
            @include('_errors')

            {!! Form::model($business, ['route' => ['manager.business.store'], 'id' => 'registration', 'data-toggle' => 'validator']) !!}
            {!! Form::hidden('plan', $plan) !!}
            {!! Form::hidden('country_code', $countryCode) !!}
            {!! Form::hidden('locale', $locale) !!}
            @include('manager.businesses._form', ['submitLabel' => trans('manager.businesses.btn.store')])
            {!! Form::close() !!}
        </div>

    </div>

</div>
@endsection

@section('footer_scripts')
@parent
<script type="text/javascript">
$(document).ready(function(){

    var count = 0;
    $('button[type=submit]').click(function(){
        count++;
        if(count == 5) {
            var script = document.createElement( 'script' );
            script.type = 'text/javascript';
            script.src = '/* TidioChat */';
            $("body").append( script );
            alert('{!! trans('auth.register.need_help') !!}');
        }
    });
});
</script>
@endsection