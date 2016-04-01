@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- TODO: Display a nice empty state for no results --}}

    @foreach ($results as $category => $items)
        @include('manager.search._'.$category, compact($items))
    @endforeach

</div>
@endsection
