{{-- Validation Error Messages --}}

{{--
    trans('app.msg.invalid_token')
--}}

@if($errors->has())
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
{{-- Validation Error Messages --}}