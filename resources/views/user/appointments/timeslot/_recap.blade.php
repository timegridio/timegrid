<h3>{{ trans('booking.steps.title.recap') }}</h3>

<section>
    <div class="container-fluid">

        @if(!isset($contact))
        @include('user.appointments.timeslot._contact-register')
        @endif

        <div class="row">
            <div class="form-group col-md-4 col-md-offset-4">
                <label for="comments">{{ trans('user.appointments.form.comments.label') }}</label>
                {!! Form::text('comments', null, [
                    'id'=>'comments',
                    'class'=>'form-control',
                    'placeholder'=> trans('user.appointments.form.comments.label')
                    ]) !!}
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4 col-md-offset-4">
                {!! Button::success(trans('user.appointments.btn.confirm_booking'))->large()->block()->submit() !!}
            </div>
        </div>

    </div>
</section>