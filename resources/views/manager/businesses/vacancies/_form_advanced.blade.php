@section('css')
@parent
<link rel="stylesheet" href="{{ asset('css/highlight.css') }}">
<style>
#vacancies{
    font-size: 1.5em;
    font-family: Monospace;
    border: 0;
    color: #555;
    line-height: 2em;
    width: 100%;
}
</style>
@endsection

<textarea id="vacancies" name="vacancies" rows="10">
sarasa:1
 mon
  9-12, 15-19
</textarea>

@if (!$business->services->isEmpty())
<div class="row">
    <div class="form-group col-sm-12">
        {!! Button::primary(trans('manager.businesses.btn.update'))->block()->large()->submit() !!}
    </div>
</div>
@endif

@section('footer_scripts')
@parent
<script src="{{ asset('js/highlight.js') }}"></script>
<script>
$(document).ready(function(){

    $('textarea').highlightTextarea({
        words: [
            {
                words: ['\\\,'],
                color: '#f0f0f0'
            },{
                words: ['mon', 'tue', 'wed', 'thu', 'fri'],
                color: '#9DD766'
            },{
                words: ['sat', 'sun'],
                color: '#D8B6B8'
            },{
                words: ['today'],
                color: '#EE8288'
            }

        ]
    });

});
</script>
@endsection