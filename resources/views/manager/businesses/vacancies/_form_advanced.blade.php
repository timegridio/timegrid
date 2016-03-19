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

<textarea id="vacancies" name="vacancies" rows="8">
{{ $template }}
</textarea>
<br>

@if (!$business->services->isEmpty())
<div class="row">
    <div class="form-group col-sm-12">
        {!! Button::success(trans('manager.businesses.btn.update'))->block()->large()->submit() !!}
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
                words: ['([\\\d\\\:])+'],
                color: '#18F818'
            },{
                words: ['\\\,'],
                color: '#E4FDE4'
            },{
                words: timegrid.services,
                color: '#CEF9CE'
            },{
                words: timegrid.humanresources,
                color: '#EDF9CE'
            },{
                words: ['mon', 'tue', 'wed', 'thu', 'fri'],
                color: '#A1EEA1'
            },{
                words: ['sat', 'sun'],
                color: '#8BE68B'
            },{
                words: ['today', 'tomorrow', 'week', 'month', 'next'],
                color: '#8BE68B'
            }

        ]
    });

});
</script>
@endsection