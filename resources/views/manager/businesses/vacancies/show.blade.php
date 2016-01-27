@extends('layouts.app')

@section('content')
<div class="container">

    @include('_errors')

    @include('manager.businesses.vacancies._days', ['dates' => $timetable])

</div>
@endsection