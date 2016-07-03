@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
@parent
@endsection

@section('content')
<div class="container-fluid">

    <div class="panel panel-default" id="dashboard">
        <div class="panel-heading">
            {{ $business->name }}
        </div>

        <div class="panel-body">
            @include('manager.businesses._notifications', compact('notifications'))
        </div>
                
    </div>

</div>
@endsection

@push('footer_scripts')
<script src="{{ asset('js/newsbox.js') }}"></script>

<script type="text/javascript">
$(".demo").bootstrapNews({
    newsPerPage: 20,
    navigation: true,
    autoplay: true,
    direction:'up', // up or down
    animationSpeed: 'normal',
    newsTickerInterval: 4000, //4 secs
    pauseOnHover: true,
    onStop: null,
    onPause: null,
    onReset: null,
    onPrev: null,
    onNext: null,
    onToDo: null
});
</script>
@endpush