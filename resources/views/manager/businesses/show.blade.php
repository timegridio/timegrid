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

    <div class="panel panel-default">
        <div class="panel-heading">
          <span class="btn-group"> 
            {!! Button::withIcon(Icon::trash())->danger()->withAttributes(['data-method' => 'DELETE', 'data-confirm' => trans('app.general.btn.confirm_deletion')])->asLinkTo( route('manager.business.destroy', $business) ) !!}
            {!! Button::withIcon(Icon::edit())->primary()->asLinkTo( route('manager.business.edit', $business) ) !!}
            {!! Button::withIcon(Icon::tag())->normal()->asLinkTo( route('manager.business.service.index', $business) ) !!}
            {!! Button::withIcon(Icon::time())->normal()->asLinkTo( route('manager.business.vacancy.create', $business) ) !!}
            {!! Button::withIcon(Icon::calendar())->normal()->asLinkTo( route('manager.business.agenda.index', $business) ) !!}
            {!! Button::withIcon(Icon::user())->normal()->asLinkTo( route('manager.business.contact.index', $business) ) !!}
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
                      <div class="panel-body"><h1 class="text-center">{{ $business->bookings()->ofDate(Carbon::now())->get()->count() }}</h1></div>
                      <div class="panel-footer">{{ trans('manager.businesses.dashboard.panel.title_appointments_today') }}</div>
                    </div>
              </div>
              <div class="col-md-2">
                    <div class="panel panel-default panel-danger">
                      <div class="panel-heading">{{ trans('manager.businesses.dashboard.panel.title_appointments_annulated') }}</div>
                      <div class="panel-body"><h1 class="text-center">{{ $business->bookings()->ofDate(Carbon::now())->annulated()->get()->count() }}</h1></div>
                      <div class="panel-footer">{{ trans('manager.businesses.dashboard.panel.title_appointments_today') }}</div>
                    </div>
              </div>
              <div class="col-md-2">
                    <div class="panel panel-default panel-warning">
                      <div class="panel-heading">{{ trans('manager.businesses.dashboard.panel.title_appointments_active') }}</div>
                      <div class="panel-body"><h1 class="text-center">{{ $business->bookings()->ofDate(Carbon::tomorrow())->active()->get()->count() }}</h1></div>
                      <div class="panel-footer">{{ trans('manager.businesses.dashboard.panel.title_appointments_tomorrow') }}</div>
                    </div>
              </div>
              <div class="col-md-2">
                    <div class="panel panel-default panel-success">
                      <div class="panel-heading">{{ trans('manager.businesses.dashboard.panel.title_appointments_active') }}</div>
                      <div class="panel-body"><h1 class="text-center">{{ $business->bookings()->active()->get()->count() }}</h1></div>
                      <div class="panel-footer">{{ trans('manager.businesses.dashboard.panel.title_appointments_total') }}</div>
                    </div>
              </div>
              <div class="col-md-2">
                    <div class="panel panel-default panel-info">
                      <div class="panel-heading">{{ trans('manager.businesses.dashboard.panel.title_appointments_served') }}</div>
                      <div class="panel-body"><h1 class="text-center">{{ $business->bookings()->served()->get()->count() }}</h1></div>
                      <div class="panel-footer">{{ trans('manager.businesses.dashboard.panel.title_appointments_total') }}</div>
                    </div>
              </div>
              <div class="col-md-2">
                    <div class="panel panel-default panel-info">
                      <div class="panel-heading">{{ trans('manager.businesses.dashboard.panel.title_appointments_total') }}</div>
                      <div class="panel-body"><h1 class="text-center">{{ $business->bookings()->get()->count() }}</h1></div>
                      <div class="panel-footer">{{ trans('manager.businesses.dashboard.panel.title_appointments_total') }}</div>
                    </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                    <div class="panel panel-default">
                      <div class="panel-heading">{{ trans('manager.businesses.dashboard.panel.title_contacts_registered') }}</div>
                      <div class="panel-body"><h2 class="text-center">{{ $business->contacts()->count() }}</h2></div>
                    </div>
              </div>
              <div class="col-md-4">
                    <div class="panel panel-default">
                      <div class="panel-heading">{{ trans('manager.businesses.dashboard.panel.title_contacts_active') }}</div>
                      <div class="panel-body"><h2 class="text-center">{{ $business->contacts()->whereNotNull('user_id')->count() }}</h2></div>
                    </div>
              </div>
              <div class="col-md-4">
                    <div class="panel panel-default">
                      <div class="panel-heading">{{ trans('manager.businesses.dashboard.panel.title_contacts_with_nin') }}</div>
                      <div class="panel-body"><h2 class="text-center">{{ $business->contacts()->whereNotNull('nin')->count() }}</h2></div>
                    </div>
              </div>
            </div>

        </div>
        <div class="panel-footer">{{ $business->name }}</div>
    </div>
</div>
@endsection

@section('footer_scripts')
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
 
})();
</script>
@endsection