@extends('layouts.app')

@section('title', trans('manager.businesses.dashboard.title'))
@section('subtitle', $business->name)

@section('css')
<link rel="stylesheet" href="{{ asset('css/tour.css') }}">
@endsection

@section('content')
<div class="container-fluid">

    @if ($business->services()->count() == 0)
    <div class="row">
        <div class="col-md-12">
            {!! Alert::warning(Button::withIcon(Icon::tag())
                ->warning()
                ->asLinkTo( route('manager.business.service.create', $business)) . '&nbsp;' .
                    trans('manager.businesses.dashboard.alert.no_services_set'))
            !!}
        </div>
    </div>
    @endif

    @if ($business->vacancies()->future()->count() == 0)
    <div class="row">
        <div class="col-md-12">
            {!! Alert::warning(Button::withIcon(Icon::time())
                ->warning()
                ->asLinkTo( route('manager.business.vacancy.create', $business)) . '&nbsp;' .
                    trans('manager.businesses.dashboard.alert.no_vacancies_set'))
            !!}
        </div>
    </div>
    @endif

    @foreach ($boxes->chunk(3) as $chunk)
        <div class="row">
            @foreach ($chunk as $box)
                <div class="col-md-4 col-sm-6 col-xs-12">
                    @include('manager.components.info-box', $box)
                </div>
            @endforeach
        </div>
    @endforeach

</div>
@endsection

@push('footer_scripts')
<script src="{{ asset('js/tour.js') }}"></script>
<script type="text/javascript">
(function() {

@if ($business->vacancies()->future()->count() == 0)
    $('#btnVacancies').tooltipster({
          animation: 'fade',
          delay: 200,
          theme: 'tooltipster-timegrid',
          touchDevices: true,
          content: $('<strong>{!! trans('manager.business.hint.out_of_vacancies') !!}</strong>')
    }).tooltipster('show');
@endif

 // Instance the tour
var tourDashboard = new Tour({
  duration: 10000,
  delay: 100,
  template: "@include('tour._template')",
  onEnd: function(tourDashboard){

    $('#btnVacancies').tooltipster({
          animation: 'fade',
          delay: 200,
          theme: 'tooltipster-timegrid',
          touchDevices: true,
          content: $('<strong>{!! trans('manager.business.hint.set_services') !!}</strong>')
    }).tooltipster('show');

  },
  steps: [
  {
    element: "#general",
    title: "{{ trans('tour.dashboard.panel.title') }}",
    content: "{{ trans('tour.dashboard.panel.content') }}",
    orphan: true,
    duration: 18000
  },
  {
    element: "#btnEdit",
    title: "{{ trans('tour.dashboard.edit.title') }}",
    content: "{{ trans('tour.dashboard.edit.content') }}",
    placement: "bottom"
  },
  {
    element: "#btnServices",
    title: "{{ trans('tour.dashboard.services.title') }}",
    content: "{{ trans('tour.dashboard.services.content') }}",
    placement: "bottom"
  },
  {
    element: "#btnVacancies",
    title: "{{ trans('tour.dashboard.vacancies.title') }}",
    content: "{{ trans('tour.dashboard.vacancies.content') }}",
    placement: "bottom"
  },
  {
    element: "#btnAgenda",
    title: "{{ trans('tour.dashboard.agenda.title') }}",
    content: "{{ trans('tour.dashboard.agenda.content') }}",
    placement: "bottom"
  },
  {
    element: "#btnContacts",
    title: "{{ trans('tour.dashboard.contacts.title') }}",
    content: "{{ trans('tour.dashboard.contacts.content') }}",
    placement: "bottom"
  },
  {
    element: "#indicator1",
    title: "{{ trans('tour.dashboard.indicator1.title') }}",
    content: "{{ trans('tour.dashboard.indicator1.content') }}",
    placement: "bottom"
  },
  {
    element: "#indicator2",
    title: "{{ trans('tour.dashboard.indicator2.title') }}",
    content: "{{ trans('tour.dashboard.indicator2.content') }}",
    placement: "bottom"
  },
  {
    element: "#indicator3",
    title: "{{ trans('tour.dashboard.indicator3.title') }}",
    content: "{{ trans('tour.dashboard.indicator3.content') }}",
    placement: "bottom"
  },
  {
    element: "#indicator4",
    title: "{{ trans('tour.dashboard.indicator4.title') }}",
    content: "{{ trans('tour.dashboard.indicator4.content') }}",
    placement: "bottom"
  },
  {
    element: "#indicator5",
    title: "{{ trans('tour.dashboard.indicator5.title') }}",
    content: "{{ trans('tour.dashboard.indicator5.content') }}",
    placement: "bottom"
  },
  {
    element: "#indicator6",
    title: "{{ trans('tour.dashboard.indicator6.title') }}",
    content: "{{ trans('tour.dashboard.indicator6.content') }}",
    placement: "bottom"
  },
  {
    element: "#indicator7",
    title: "{{ trans('tour.dashboard.indicator7.title') }}",
    content: "{{ trans('tour.dashboard.indicator7.content') }}",
    placement: "top"
  },
  {
    element: "#indicator8",
    title: "{{ trans('tour.dashboard.indicator8.title') }}",
    content: "{{ trans('tour.dashboard.indicator8.content') }}",
    placement: "top"
  },
  {
    element: "#indicator9",
    title: "{{ trans('tour.dashboard.indicator9.title') }}",
    content: "{{ trans('tour.dashboard.indicator9.content') }}",
    placement: "top"
  },
  {
    element: "#search",
    title: "{{ trans('tour.dashboard.search.title') }}",
    content: "{{ trans('tour.dashboard.search.content') }}",
    placement: "bottom",
    duration: 12000
  },
  {
    element: "#navHome",
    title: "{{ trans('tour.dashboard.home.title') }}",
    content: "{{ trans('tour.dashboard.home.content') }}",
    placement: "bottom"
  },
  {
    element: "#navLang",
    title: "{{ trans('tour.dashboard.lang.title') }}",
    content: "{{ trans('tour.dashboard.lang.content') }}",
    placement: "bottom",
    duration: 12000
  },
  {
    element: "#navProfile",
    title: "{{ trans('tour.dashboard.profile.title') }}",
    content: "{{ trans('tour.dashboard.profile.content') }}",
    placement: "bottom"
  },
  {
    element: "#btnDelete",
    title: "{{ trans('tour.dashboard.delete.title') }}",
    content: "{{ trans('tour.dashboard.delete.content') }}",
    placement: "bottom"
  },
  {
    element: "#enjoy",
    title: "{{ trans('tour.dashboard.enjoy.title') }}",
    content: "{{ trans('tour.dashboard.enjoy.content') }}",
    orphan: true,
    duration: 20000,
  },
]});

// Initialize the tour
tourDashboard.init();

// Start the tour
tourDashboard.start();

})();
</script>
@endpush