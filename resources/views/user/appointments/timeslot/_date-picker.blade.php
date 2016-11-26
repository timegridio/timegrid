@section('css')
@parent
<link rel="stylesheet" href="{{ asset('css/datetime.css') }}">
<style>
.disabled-day {
    background: #ddb0aa;
    text-decoration: line-through;
}
</style>
@endsection

<h3>{{ trans('booking.steps.title.pick-a-date') }}</h3>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="form-group col-md-4 col-md-offset-4">
                <div id="datepicker"
                       type="text"
                       language="en"
                       class="datepicker-here"
                       data-multiple-dates="false"
                       data-show-other-months="true"
                       data-date-format="yyyy-m-d"
                       data-today-button="false"></div>
            </div>
        </div>
    </div>
</section>

@push('footer_scripts')
<script src="{{ asset('js/datetime.js') }}" ></script>
@endpush