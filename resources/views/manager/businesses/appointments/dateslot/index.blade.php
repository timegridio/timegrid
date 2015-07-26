@extends('app')

@section('content')
{!! Form::open(['id' => 'postAppointmentStatus', 'method' => 'post', 'route' => ['api.booking.action']]) !!}
{!! Form::hidden('business', $business->id) !!}
<div class="container">

    {!! Widget::AppointmentsTable(['appointments' => $appointments, 'user' => \Auth::user(), 'business' => $business]) !!}

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

        var business = $('input[name=business]').val();
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

});
</script>
@endsection