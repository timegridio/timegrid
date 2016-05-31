@section('css')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endsection

<!-- List group -->
{!! Form::open(['id' => 'save', 'method' => 'post', 'route' => ['manager.business.vacancy.update', $service->business]]) !!}
{!! Form::hidden('serviceId', $service->id) !!}
<ul class="list-group">
    <li class="list-group-item">{{ trans('datetime.weekday.monday') }}
        <span class="pull-right"><input type="checkbox" data-size="mini" class="weekday" name="weekdays[mon]" checked></span>
    </li>
    <li class="list-group-item">{{ trans('datetime.weekday.tuesday') }}
        <span class="pull-right"><input type="checkbox" data-size="mini" class="weekday" name="weekdays[tue]" checked></span>
    </li>
    <li class="list-group-item">{{ trans('datetime.weekday.wednesday') }}
        <span class="pull-right"><input type="checkbox" data-size="mini" class="weekday" name="weekdays[wed]" checked></span>
    </li>
    <li class="list-group-item">{{ trans('datetime.weekday.thursday') }}
        <span class="pull-right"><input type="checkbox" data-size="mini" class="weekday" name="weekdays[thu]" checked></span>
    </li>
    <li class="list-group-item">{{ trans('datetime.weekday.friday') }}
        <span class="pull-right"><input type="checkbox" data-size="mini" class="weekday" name="weekdays[fri]" checked></span>
    </li>
    <li class="list-group-item">{{ trans('datetime.weekday.saturday') }}
        <span class="pull-right"><input type="checkbox" data-size="mini" class="weekday" name="weekdays[sat]"></span>
    </li>
    <li class="list-group-item">{{ trans('datetime.weekday.sunday') }}
        <span class="pull-right"><input type="checkbox" data-size="mini" class="weekday" name="weekdays[sun]"></span>
    </li>
</ul>
{!! Form::close() !!}

@section('footer_scripts')
<script src="{{ asset('js/forms.js') }}"></script>
@parent
<script type="text/javascript">
$(document).ready(function(){

    $('#save').submit(function(event) {

        var formData = $(this).serializeArray();

        $.ajax({
            type      : 'POST',
            url       : $(this).attr('action'),
            data      : formData,
            dataType  : 'json',
            encode    : true
        }).done(function(data) {

            console.log(data);
            console.log('Availability updated OK'); 

        }).error(function(data) {

            console.log('Availability could not be updated'); 

        });

        event.preventDefault();

        return false;
    });

    var timer;
    $("[type='checkbox']").bootstrapSwitch().on('switchChange.bootstrapSwitch', function(event, state) {

        window.clearTimeout(timer);
        timer = window.setTimeout(function(){

            $('#save').submit();

        }, 3000);
    });
});
</script>
@endsection