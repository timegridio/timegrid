@extends('layouts.app')

@section('css')
@parent
<style type="text/css">
.btn-clean {
  display: inline;
  padding: 12px 16px;
  background: #fafafa;
  border: 1px solid #bfbfbf;
  border-radius: 2px;
  text-decoration: none;
  color: #8f8f8f;
  font-size: 2em;
  -webkit-transition: all .25s ease-in-out;
  -moz-transition: all .25s ease-in-out;
  -ms-transition: all .25s ease-in-out;
  -o-transition: all .25s ease-in-out;
  transition: all .25s ease-in-out;
  width: 70%;
}

.btn-clean i {
  position: relative;
  top: 1px;
  margin-left: -34px;
  font-size: 1.15em;
}

.btn-clean:hover,
.btn-clean:focus,
.btn-clean:active,
.clean.button-group.open .button {
  border-color: #8f8f8f;
  color: #808080;
  text-decoration: none;
}

.btn-clean input {
  border: 0;
  width: 100%;
}
</style>
@endsection

@section('content')
<div class="container-fluid">

  <div class="text-center">
    <h1>{{ trans('emptystate.manager.appointments.title') }}</h1>
    <p class="lead">{{ trans('emptystate.manager.appointments.hint') }}</p>

    <button class="btn-clean btn btn-lg" data-clipboard-target="#link">
        <input id="link" value="{{ url('/'.$business->slug) }}" readonly/>
        <i class="ion-link"></i>
    </button>
  </div>

</div>
@endsection

@push('footer_scripts')
<script src="{{ asset('js/clipboard/clipboard.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){    
    new Clipboard('.btn');
});
</script>
@endpush