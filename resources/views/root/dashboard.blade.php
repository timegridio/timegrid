@extends('root.app')

@section('content')
<div class="container">
    
    <h1>Registered Users</h1>
    {!! Table::withContents($users->toArray())->striped()->condensed()->hover() !!}

</div>
@endsection
