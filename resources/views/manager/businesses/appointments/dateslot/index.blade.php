@extends('app')

@section('content')
{!! Form::open(['id' => 'postAppointmentStatus', 'method' => 'post', 'route' => ['manager.business.agenda.action']]) !!}
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('user.appointments.index.title') }}</div>
            <div class="panel-body">
                <table class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th><span class="hidden-md">{!! Icon::barcode() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.code') }}</span></th>
                            <th><span class="hidden-md">{!! Icon::user() !!}</span> <span class="">{{ trans('user.appointments.index.th.contact') }}</span></th>
                            <th><span class="hidden-md">{!! Icon::asterisk() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.status') }}</span></th>
                            <th><span class="hidden-md">{!! Icon::calendar() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.calendar') }}</span></th>
                            <th><span class="hidden-md">{!! Icon::time() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.start_time') }}</span></th>
                            <th><span class="hidden-md">{!! Icon::briefcase() !!}</span> <span class="hidden-xs hidden-sm">{{ trans('user.appointments.index.th.service') }}</span></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="searchable">
                    @foreach ($appointments as $appointment)
                        {!! $appointment->widget()->row() !!}
                    @endforeach
                    </tbody>
                </table>
            </div>
        <div class="panel-footer">
            <div class="input-group"> <span class="input-group-addon">{{ trans('app.filter') }}</span><input id="filter" type="text" class="form-control" placeholder=""></div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection

@section('footer_scripts')
@parent
<script>
$(document).ready(function(){

function prepareEvents(){

        console.log('prepareEvents()');

        var form = $('#postAppointmentStatus');
        var button = $('.action');
        var buttons = $('.actiongroup');
        var token = $('input[name=_token]');

        button.click(function (event){

        event.preventDefault();

        var business = $(this).data('business');
        var appointment = $(this).data('appointment');
        var action = $(this).data('action');
        var code = $(this).data('code');
        var row = $('#'+code);

        $(this).parent().hide();

            $.ajax({
                url: form.attr('action'),
                method: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                data: { business: business, appointment: appointment, action: action, widget:'row' }
            }).done(function (data) {
                    console.log('AJAX Done');
                    $('#'+code).replaceWith(data.html);
            }).fail(function (data) {
                    console.log('AJAX Fail');
            }).always(function (data) {
                    $(this).parent().show();
                    prepareEvents();
                    console.log('AJAX Finish');
                    console.log(data);
            });
        });
    }

prepareEvents();

(function ($) {

    $('#filter').keyup(function () {

        var search = $(this).val();

        /* Enable multifield search */
        search = search.replace(/\ /g, '\.\*');
        
        var rex = new RegExp(search, 'i');
        $('.searchable tr').hide();
        $('.searchable tr').filter(function () {
            return rex.test($(this).text());
        }).show();

    })

}(jQuery));

});
</script>
@endsection