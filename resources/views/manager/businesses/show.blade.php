@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
<link rel="stylesheet" href="{{ asset('css/tour.css') }}">
@parent
<style type="text/css">
.bizurl:hover {
    color: #444;
}
.bizurl {
    font-family: monospace;
    color: #ddd;
}
</style>
@endsection

@section('content')
<div class="container-fluid">

    <div class="panel panel-default panel-fluid" id="dashboard">
        <div class="panel-heading">
            {{ $business->name }}
            <span class="bizurl pull-right">{{ route('guest.business.home', $business->slug) }}</span>
        </div>

        <div class="panel-body">

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

            <div class="row">
                <div class="col-md-2">
                    <div class="panel panel-default panel-success">
                        <div class="panel-heading">
                            {{ trans('manager.businesses.dashboard.panel.title_appointments_active') }}
                        </div>
                        <div class="panel-body" id="indicator1">
                            <h1 class="text-center">{{ array_get($dashboard, 'appointments_active_today', '?') }}</h1>
                        </div>
                        <div class="panel-footer">
                            {{ trans('manager.businesses.dashboard.panel.title_appointments_today') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel panel-default panel-danger">
                        <div class="panel-heading">
                            {{ trans('manager.businesses.dashboard.panel.title_appointments_canceled') }}
                        </div>
                        <div class="panel-body" id="indicator2">
                            <h1 class="text-center">{{ array_get($dashboard, 'appointments_canceled_today', '?') }}</h1>
                        </div>
                        <div class="panel-footer">
                            {{ trans('manager.businesses.dashboard.panel.title_appointments_today') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel panel-default panel-warning">
                        <div class="panel-heading">
                            {{ trans('manager.businesses.dashboard.panel.title_appointments_active') }}
                        </div>
                        <div class="panel-body" id="indicator3">
                            <h1 class="text-center">{{ array_get($dashboard, 'appointments_active_tomorrow', '?') }}</h1>
                        </div>
                        <div class="panel-footer">
                            {{ trans('manager.businesses.dashboard.panel.title_appointments_tomorrow') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel panel-default panel-success">
                        <div class="panel-heading">
                            {{ trans('manager.businesses.dashboard.panel.title_appointments_active') }}
                        </div>
                        <div class="panel-body" id="indicator4">
                            <h1 class="text-center">{{ array_get($dashboard, 'appointments_active_total', '?') }}</h1>
                        </div>
                        <div class="panel-footer">
                            {{ trans('manager.businesses.dashboard.panel.title_total') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel panel-default panel-info">
                        <div class="panel-heading">
                            {{ trans('manager.businesses.dashboard.panel.title_appointments_served') }}
                        </div>
                        <div class="panel-body" id="indicator5">
                            <h1 class="text-center">{{ array_get($dashboard, 'appointments_served_total', '?') }}</h1>
                        </div>
                        <div class="panel-footer">
                            {{ trans('manager.businesses.dashboard.panel.title_total') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel panel-default panel-info">
                        <div class="panel-heading">
                            {{ trans('manager.businesses.dashboard.panel.title_appointments_total') }}
                        </div>
                        <div class="panel-body" id="indicator6">
                            <h1 class="text-center">{{ array_get($dashboard, 'appointments_total', '?') }}</h1>
                        </div>
                        <div class="panel-footer">
                            {{ trans('manager.businesses.dashboard.panel.title_total') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ trans('manager.businesses.dashboard.panel.title_contacts_registered') }}
                        </div>
                        <div class="panel-body" id="indicator7">
                            <h2 class="text-center">{{ array_get($dashboard, 'contacts_registered', '?') }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ trans('manager.businesses.dashboard.panel.title_contacts_active') }}
                        </div>
                        <div class="panel-body" id="indicator8">
                            <h2 class="text-center">{{ array_get($dashboard, 'contacts_subscribed', '?') }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-8" title="{{ $time }}">
                    @include('manager.businesses._notifications', ['notifications' => $notifications ])
                </div>

            </div>

        </div>

        <div class="panel-footer">
            <span class="btn-group">
                {!! Button::withIcon(Icon::cog())->normal()->withAttributes(['id' => 'btnPreferences', 'title' => trans('manager.business.btn.tooltip.preferences')])->asLinkTo( route('manager.business.preferences', $business) ) !!}
                {!! Button::withIcon(Icon::edit())->normal()->withAttributes(['id' => 'btnEdit', 'title' => trans('manager.business.btn.tooltip.edit')])->asLinkTo( route('manager.business.edit', $business) ) !!}
                {!! Button::withIcon(Icon::time())->normal()->withAttributes(['title' => trans('manager.business.btn.tooltip.vacancies')])->asLinkTo( route('manager.business.vacancy.show', $business) ) !!}
                {!! Button::withIcon(Icon::bullhorn())->normal()->withAttributes(['title' => trans('manager.business.btn.tooltip.notifications')])->asLinkTo( route('manager.business.notifications.show', $business) ) !!}
            </span>
        </div>

    </div>

</div>
@endsection

@section('footer_scripts')
@parent
<script src="{{ asset('js/newsbox.js') }}"></script>
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
    title: "{{trans('tour.dashboard.panel.title')}}",
    content: "{{trans('tour.dashboard.panel.content')}}",
    orphan: true,
    duration: 18000
  },
  {
    element: "#btnEdit",
    title: "{{trans('tour.dashboard.edit.title')}}",
    content: "{{trans('tour.dashboard.edit.content')}}",
    placement: "bottom"
  },
  {
    element: "#btnServices",
    title: "{{trans('tour.dashboard.services.title')}}",
    content: "{{trans('tour.dashboard.services.content')}}",
    placement: "bottom"
  },
  {
    element: "#btnVacancies",
    title: "{{trans('tour.dashboard.vacancies.title')}}",
    content: "{{trans('tour.dashboard.vacancies.content')}}",
    placement: "bottom"
  },
  {
    element: "#btnAgenda",
    title: "{{trans('tour.dashboard.agenda.title')}}",
    content: "{{trans('tour.dashboard.agenda.content')}}",
    placement: "bottom"
  },
  {
    element: "#btnContacts",
    title: "{{trans('tour.dashboard.contacts.title')}}",
    content: "{{trans('tour.dashboard.contacts.content')}}",
    placement: "bottom"
  },
  {
    element: "#indicator1",
    title: "{{trans('tour.dashboard.indicator1.title')}}",
    content: "{{trans('tour.dashboard.indicator1.content')}}",
    placement: "bottom"
  },
  {
    element: "#indicator2",
    title: "{{trans('tour.dashboard.indicator2.title')}}",
    content: "{{trans('tour.dashboard.indicator2.content')}}",
    placement: "bottom"
  },
  {
    element: "#indicator3",
    title: "{{trans('tour.dashboard.indicator3.title')}}",
    content: "{{trans('tour.dashboard.indicator3.content')}}",
    placement: "bottom"
  },
  {
    element: "#indicator4",
    title: "{{trans('tour.dashboard.indicator4.title')}}",
    content: "{{trans('tour.dashboard.indicator4.content')}}",
    placement: "bottom"
  },
  {
    element: "#indicator5",
    title: "{{trans('tour.dashboard.indicator5.title')}}",
    content: "{{trans('tour.dashboard.indicator5.content')}}",
    placement: "bottom"
  },
  {
    element: "#indicator6",
    title: "{{trans('tour.dashboard.indicator6.title')}}",
    content: "{{trans('tour.dashboard.indicator6.content')}}",
    placement: "bottom"
  },
  {
    element: "#indicator7",
    title: "{{trans('tour.dashboard.indicator7.title')}}",
    content: "{{trans('tour.dashboard.indicator7.content')}}",
    placement: "top"
  },
  {
    element: "#indicator8",
    title: "{{trans('tour.dashboard.indicator8.title')}}",
    content: "{{trans('tour.dashboard.indicator8.content')}}",
    placement: "top"
  },
  {
    element: "#indicator9",
    title: "{{trans('tour.dashboard.indicator9.title')}}",
    content: "{{trans('tour.dashboard.indicator9.content')}}",
    placement: "top"
  },
  {
    element: "#search",
    title: "{{trans('tour.dashboard.search.title')}}",
    content: "{{trans('tour.dashboard.search.content')}}",
    placement: "bottom",
    duration: 12000
  },
  {
    element: "#navHome",
    title: "{{trans('tour.dashboard.home.title')}}",
    content: "{{trans('tour.dashboard.home.content')}}",
    placement: "bottom"
  },
  {
    element: "#navLang",
    title: "{{trans('tour.dashboard.lang.title')}}",
    content: "{{trans('tour.dashboard.lang.content')}}",
    placement: "bottom",
    duration: 12000
  },
  {
    element: "#navProfile",
    title: "{{trans('tour.dashboard.profile.title')}}",
    content: "{{trans('tour.dashboard.profile.content')}}",
    placement: "bottom"
  },
  {
    element: "#btnDelete",
    title: "{{trans('tour.dashboard.delete.title')}}",
    content: "{{trans('tour.dashboard.delete.content')}}",
    placement: "bottom"
  },
  {
    element: "#enjoy",
    title: "{{trans('tour.dashboard.enjoy.title')}}",
    content: "{{trans('tour.dashboard.enjoy.content')}}",
    orphan: true,
    duration: 20000,
  },
]});

// Initialize the tour
tourDashboard.init();

// Start the tour
tourDashboard.start();

$(".demo").bootstrapNews({
newsPerPage: 4,
navigation: true,
autoplay: true,
direction:'up', // up or down
animationSpeed: 'normal',
newsTickerInterval: 4000, //4 secs
pauseOnHover: true,
onStop: null,
onPause: null,
onReset: null,
onPrev: null,
onNext: null,
onToDo: null
});

})();
</script>
@endsection