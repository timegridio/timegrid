@extends('layouts.app')

@section('title', trans('manager.businesses.notifications.title'))
@section('subtitle', trans('manager.businesses.notifications.help'))

@section('css')
<link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
@parent
@endsection

@section('content')
<div class="container-fluid">

    @include('manager.businesses._notifications', compact('notifications'))

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