@extends('app')

@section('content')
<div class="container"> 
    @foreach ($results as $category => $items)
            @include('manager.search._'.$category, ['items' => $items])
    @endforeach
</div>
@endsection
