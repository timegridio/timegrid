@section('css')
@parent
<style>
.box {
    background:#fff;
    transition:all 0.2s ease;
    border:2px dashed #dadada;
    margin-top: 6px;
    box-sizing: border-box;
    border-radius: 5px;
    background-clip: padding-box;
    padding:0 20px 20px 20px;
    min-height:340px;
}
.box:hover {
    border:2px solid #525C7A;
}
.box span.box-title {
    color: #fff;
    font-size: 24px;
    font-weight: 300;
    text-transform: uppercase;
}
.box .box-content {
    padding: 16px;
    border-radius: 0 0 2px 2px;
    background-clip: padding-box;
    box-sizing: border-box;
}
.box .box-content p {
    color:#515c66;
    text-transform:none;
}
.duration-title {
    font-size: smaller;
    color: #999;
    text-transform:none;
}
</style>
@endsection

<h3>{{ trans('booking.steps.title.pick-a-service') }}</h3>

<section style="overflow:scroll;">
    <div class="container-fluid">
        <div class="row">
            @foreach($services as $service)
            <div class="col-md-4 text-center">
                <div class="box">
                    <div class="box-content">
                        <h1 class="tag-title">{{ $service->name }}</h1>
                        <h2 class="duration-title">
                            @if($service->duration)
                            <span class="text-muted">{{ trans_duration("{$service->duration} minutes") }}</span>
                            @endif
                        </h2>
                        <hr />
                        <p>{!! Markdown::convertToHtml(strip_tags($service->description)) !!}</p>
                        <br />
                        <a href="#" class="btn btn-block btn-primary btn-lg service-btn" data-service-id="{{ $service->id }}">{{ $service->name }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@push('footer_scripts')
<script>

    function updateDatepicker()
    {
        var business = $('#business').val();
        var service = $('#service').val();

        $.ajax({
            url:'/api/vacancies/' + business + '/' + service,
            type:'GET',
            dataType: 'json',
            success: function( data ) {
                disabledDates = data.disabledDates;
                console.log('disabledDates:' + disabledDates);
                $('#datepicker').datepicker('setDatesDisabled', disabledDates);
                $('#datepicker').show();
            },
            fail: function ( data ) {
                console.log('Failed to load dates.');
            }
        });
    }

    $(document).ready(function(){

        $(".service-btn").click(function(){
            var serviceId = $(this).data('service-id');
            $('#service').val(serviceId);
            $('#service').change();

            updateDatepicker();
        });

    });

</script>
@endpush