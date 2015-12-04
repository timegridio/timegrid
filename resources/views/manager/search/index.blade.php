@extends('app')

@section('content')
<div class="container"> 
@if ($results)
    {!! Alert::info(trans('app.search.msg.no_results', ['criteria' => $criteria])) !!}
@else
    @foreach ($results as $category => $items)
            @include('manager.search._'.$category, ['items' => $items])
    @endforeach
@endif
</div>
@endsection
