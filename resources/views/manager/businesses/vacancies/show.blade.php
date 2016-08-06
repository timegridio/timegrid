@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('manager.businesses.vacancies._days', ['dates' => $timetable])

</div>
@endsection