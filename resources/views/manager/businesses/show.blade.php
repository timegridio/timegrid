@extends('app')

@section('css')
@parent
<style>
.bizurl {
    font-family: monospace;
    background: #ECECEC;
    padding: 10px 8px;
    margin: 0px 0px 20px 0px;
}
</style>
@endsection

@section('content')
<div class="container">

    <div class="panel panel-default" id="dashboard">
        <div class="panel-heading">
          <span class="btn-group"> 
            {!! Button::withIcon(Icon::trash())->danger()->withAttributes(['id' => 'btnDelete', 'data-method' => 'DELETE', 'data-confirm' => trans('app.general.btn.confirm_deletion')])->asLinkTo( route('manager.business.destroy', $business) ) !!}
            {!! Button::withIcon(Icon::edit())->primary()->withAttributes(['id' => 'btnEdit'])->asLinkTo( route('manager.business.edit', $business) ) !!}
            {!! Button::withIcon(Icon::tag())->normal()->withAttributes(['id' => 'btnServices'])->asLinkTo( route('manager.business.service.index', $business) ) !!}
            {!! Button::withIcon(Icon::time())->normal()->withAttributes(['id' => 'btnVacancies'])->asLinkTo( route('manager.business.vacancy.create', $business) ) !!}
            {!! Button::withIcon(Icon::calendar())->withAttributes(['id' => 'btnAgenda'])->normal()->asLinkTo( route('manager.business.agenda.index', $business) ) !!}
            {!! Button::withIcon(Icon::user())->withAttributes(['id' => 'btnContacts'])->normal()->asLinkTo( route('manager.business.contact.index', $business) ) !!}
          </span>
        </div>

        <div class="panel-body">

            @if ($business->services()->count() == 0)
            <div class="row">
                <div class="col-md-12">
                    {!! Alert::warning(Button::withIcon(Icon::tag())->warning()->asLinkTo( route('manager.business.service.create', $business)) . '&nbsp;' . trans('manager.businesses.dashboard.alert.no_services_set')) !!}
                </div>
            </div>
            @endif

            @if ($business->vacancies()->future()->count() == 0)
            <div class="row">
                <div class="col-md-12">
                    {!! Alert::warning(Button::withIcon(Icon::time())->warning()->asLinkTo( route('manager.business.vacancy.create', $business)) . '&nbsp;' . trans('manager.businesses.dashboard.alert.no_vacancies_set')) !!}
                </div>
            </div>
            @endif

{{--             <div class="row">
              <div class="col-md-4"><blockquote><p>{{ str_limit($business->description, 30) }}</div>
              <div class="col-md-4"><blockquote><p>{!! Icon::globe() !!}&nbsp;{{ $business->timezone }}</p></blockquote></div>
              <div class="col-md-4"><div class="bizurl">{{ URL::to($business->slug) }}</div></div>
            </div> --}}

            <div class="row">
              <div class="col-md-2">
                    <div class="panel panel-default panel-success">
                      <div class="panel-heading">{{ trans('manager.businesses.dashboard.panel.title_appointments_active') }}</div>
                      <div class="panel-body" id="indicator1"><h1 class="text-center">{{ $business->bookings()->ofDate(Carbon::now())->get()->count() }}</h1></div>
                      <div class="panel-footer">{{ trans('manager.businesses.dashboard.panel.title_appointments_today') }}</div>
                    </div>
              </div>
              <div class="col-md-2">
                    <div class="panel panel-default panel-danger">
                      <div class="panel-heading">{{ trans('manager.businesses.dashboard.panel.title_appointments_annulated') }}</div>
                      <div class="panel-body" id="indicator2"><h1 class="text-center">{{ $business->bookings()->ofDate(Carbon::now())->annulated()->get()->count() }}</h1></div>
                      <div class="panel-footer">{{ trans('manager.businesses.dashboard.panel.title_appointments_today') }}</div>
                    </div>
              </div>
              <div class="col-md-2">
                    <div class="panel panel-default panel-warning">
                      <div class="panel-heading">{{ trans('manager.businesses.dashboard.panel.title_appointments_active') }}</div>
                      <div class="panel-body" id="indicator3"><h1 class="text-center">{{ $business->bookings()->ofDate(Carbon::tomorrow())->active()->get()->count() }}</h1></div>
                      <div class="panel-footer">{{ trans('manager.businesses.dashboard.panel.title_appointments_tomorrow') }}</div>
                    </div>
              </div>
              <div class="col-md-2">
                    <div class="panel panel-default panel-success">
                      <div class="panel-heading">{{ trans('manager.businesses.dashboard.panel.title_appointments_active') }}</div>
                      <div class="panel-body" id="indicator4"><h1 class="text-center">{{ $business->bookings()->active()->get()->count() }}</h1></div>
                      <div class="panel-footer">{{ trans('manager.businesses.dashboard.panel.title_appointments_total') }}</div>
                    </div>
              </div>
              <div class="col-md-2">
                    <div class="panel panel-default panel-info">
                      <div class="panel-heading">{{ trans('manager.businesses.dashboard.panel.title_appointments_served') }}</div>
                      <div class="panel-body" id="indicator5"><h1 class="text-center">{{ $business->bookings()->served()->get()->count() }}</h1></div>
                      <div class="panel-footer">{{ trans('manager.businesses.dashboard.panel.title_appointments_total') }}</div>
                    </div>
              </div>
              <div class="col-md-2">
                    <div class="panel panel-default panel-info">
                      <div class="panel-heading">{{ trans('manager.businesses.dashboard.panel.title_appointments_total') }}</div>
                      <div class="panel-body" id="indicator6"><h1 class="text-center">{{ $business->bookings()->get()->count() }}</h1></div>
                      <div class="panel-footer">{{ trans('manager.businesses.dashboard.panel.title_appointments_total') }}</div>
                    </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                    <div class="panel panel-default">
                      <div class="panel-heading">{{ trans('manager.businesses.dashboard.panel.title_contacts_registered') }}</div>
                      <div class="panel-body" id="indicator7"><h2 class="text-center">{{ $business->contacts()->count() }}</h2></div>
                    </div>
              </div>
              <div class="col-md-4">
                    <div class="panel panel-default">
                      <div class="panel-heading">{{ trans('manager.businesses.dashboard.panel.title_contacts_active') }}</div>
                      <div class="panel-body" id="indicator8"><h2 class="text-center">{{ $business->contacts()->whereNotNull('user_id')->count() }}</h2></div>
                    </div>
              </div>
              <div class="col-md-4">
                    <div class="panel panel-default">
                      <div class="panel-heading">{{ trans('manager.businesses.dashboard.panel.title_contacts_with_nin') }}</div>
                      <div class="panel-body" id="indicator9"><h2 class="text-center">{{ $business->contacts()->whereNotNull('nin')->count() }}</h2></div>
                    </div>
              </div>
            </div>

        </div>
        <div class="panel-footer">{{ $business->name }}</div>
    </div>
</div>
@endsection

@section('footer_scripts')
@parent
<script src="{{ asset('js/bootstrap-tour.min.js') }}"></script>
<script type="text/javascript">
(function() {
 
  var laravel = {
    initialize: function() {
      this.methodLinks = $('a[data-method]');
      this.registerEvents();
    },
 
    registerEvents: function() {
      this.methodLinks.on('click', this.handleMethod);
    },
 
    handleMethod: function(e) {
      var link = $(this);
      var httpMethod = link.data('method').toUpperCase();
      var form;
 
      // If the data-method attribute is not PUT or DELETE,
      // then we don't know what to do. Just ignore.
      if ( $.inArray(httpMethod, ['PUT', 'DELETE']) === - 1 ) {
        return;
      }
 
      // Allow user to optionally provide data-confirm="Are you sure?"
      if ( link.data('confirm') ) {
        if ( ! laravel.verifyConfirm(link) ) {
          return false;
        }
      }
 
      form = laravel.createForm(link);
      form.submit();
 
      e.preventDefault();
    },
 
    verifyConfirm: function(link) {
      return confirm(link.data('confirm'));
    },
 
    createForm: function(link) {
      var form =
      $('<form>', {
        'method': 'POST',
        'action': link.attr('href')
      });
 
      var token =
      $('<input>', {
        'type': 'hidden',
        'name': '_token',
          'value': '{{{ csrf_token() }}}' // hmmmm...
        });
 
      var hiddenInput =
      $('<input>', {
        'name': '_method',
        'type': 'hidden',
        'value': link.data('method')
      });
 
      return form.append(token, hiddenInput).appendTo('body');
    }
  };
 
  laravel.initialize();

 // Instance the tour
var tourDashboard = new Tour({
  duration: 10000,
  delay: 100,
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
    duration: 20000
  },
]});

// Initialize the tour
tourDashboard.init();

// Start the tour
tourDashboard.start();

})();
</script>
@endsection

