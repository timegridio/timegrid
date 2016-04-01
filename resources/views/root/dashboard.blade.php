@extends('layouts.user')

@section('content')
<div class="container-fluid">
    
    <h1>Registered Users</h1>
    {!! Table::withContents($users->toArray())->striped()->condensed()->hover() !!}

</div>
@endsection
