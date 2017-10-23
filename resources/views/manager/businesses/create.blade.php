@extends('layouts.bare')

@section('title', trans('manager.businesses.create.title'))
@section('subtitle', trans('manager.businesses.msg.register', ['plan' => trans($plan)]))

@section('content')
<div class="col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2">

    @unless(config('root.app.allow_register_business'))
    <div class="alert alert-danger">
        {{ trans('app.allow_register_business') }}
    </div>
    @endif


    <div class="panel panel-default">

        <div class="panel-heading">
        {{ trans('manager.businesses.create.title') }}
        </div>

        <div class="panel-body">
            {!! Form::model($business, ['route' => ['manager.business.store'], 'id' => 'registration', 'data-toggle' => 'validator', 'class' => 'form-horizontal']) !!}
            <fieldset>
            {!! Form::hidden('plan', $plan) !!}
            {!! Form::hidden('country_code', $countryCode) !!}
            {!! Form::hidden('locale', $locale) !!}
            @include('manager.businesses._form', ['submitLabel' => trans('manager.businesses.btn.store')])
            </fieldset>
            {!! Form::close() !!}
        </div>

    </div>

</div>
@endsection

@push('footer_scripts')
<script type="text/javascript">
$(document).ready(function(){

    var count = 0;
    $('button[type=submit]').click(function(){
        count++;
        if(count == 5) {
            var script = document.createElement( 'script' );
            script.type = 'text/javascript';
            script.src = '{{ TidioChat::src() }}';
            $("body").append( script );
            alert('{!! trans('auth.register.need_help') !!}');
        }
    });
});
</script>
@endpush