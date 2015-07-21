<table class="table table-condensed table-hover">
<tr>
    <th>{{ trans('manager.vacancies.table.th.date') }}</th>
    @foreach ($services as $service)
    <th>{{ $service->name }}</th>
    @endforeach
</tr>
@foreach ($dates as $date => $vacancies)
    <tr>
        <td title="{{ Carbon::parse($date)->formatLocalized('%A %d %B') }}">{{ $date }}</td>
    @foreach ($services as $service)
        @if(count($vacancies) > 0 && array_key_exists($service->slug, $vacancies))
            <td> {!! Form::text("vacancy[$date][$service->id]", $vacancies[$service->slug]->capacity, array('class'=>'form-control', 'type' => 'numeric', 'step' => '1', 'placeholder'=> "$date {$service->name} ({$vacancies[$service->slug]->capacity})" )) !!} </td>
        @else
            <td> {!! Form::text("vacancy[$date][$service->id]", null, array('class'=>'form-control', 'placeholder'=> "$date {$service->name}" )) !!} </td>
        @endif
    @endforeach
    </tr>
@endforeach
</table>  

<div class="row">
    <div class="form-group col-sm-12">
        {!! Button::primary(trans('manager.businesses.btn.update'))->block()->large()->submit() !!}
    </div>
</div>
