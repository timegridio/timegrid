@extends('layouts.app')

@section('title', trans('manager.services.index.title'))
@section('subtitle', trans('manager.services.index.instructions'))

@section('content')
<div class="container-fluid">
    <div class="col-md-6 col-md-offset-3">

        <div class="panel panel-default">

            <div class="panel-body">

                @foreach ($business->services as $service)
                <p>
                    <div class="btn-group">

                        {!! Button::danger()->withIcon(Icon::trash())->withAttributes([
                            'type' => 'button',
                            'data-toggle' => 'tooltip',
                            'data-original-title' => trans('manager.service.btn.delete'),
                            'data-method' => 'DELETE',
                            'data-confirm' => trans('manager.service.btn.delete').'?']
                        )->asLinkTo( route('manager.business.service.destroy', [$service->business, $service]) ) !!}

                        {!! Button::normal()
                            ->withIcon(Icon::edit())
                            ->asLinkTo(route('manager.business.service.edit', [$business, $service->id]) ) !!}

                        @if($service->type)
                        {!! Button::normal($service->type->name) !!}
                        @endif

                        {!! Button::normal($service->name)
                            ->asLinkTo( route('manager.business.service.show', [$business, $service->id]) ) !!}
                    </div>
                </p>
                @endforeach
                
            </div>

            <div class="panel-footer">
                {!! Button::primary(trans('manager.services.btn.create'))
                    ->withIcon(Icon::plus())
                    ->asLinkTo( route('manager.business.service.create', [$business]) )
                    ->block() !!}

                {!! Button::primary(trans('servicetype.btn.edit'))
                    ->asLinkTo( route('manager.business.servicetype.edit', [$business]) )
                    ->block() !!}
            </div>

        </div>
        @if ($business->services()->count())
        {!! Alert::success(trans('manager.services.create.alert.go_to_vacancies')) !!}
        {!! Button::success(trans('manager.services.create.btn.go_to_vacancies'))
            ->withIcon(Icon::time())
            ->asLinkTo(route('manager.business.vacancy.create', $business))
            ->large()
            ->block() !!}
        @endif
    </div>
</div>
@endsection

@push('footer_scripts')
<script>
$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();

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
                    'value': '{{ csrf_token() }}'
                });
 
            var hiddenInput =
            $('<input>', {
                'name': '_method',
                'type': 'hidden',
                'value': link.data('method')
            });
 
            return form.append(token, hiddenInput)
                                 .appendTo('body');
        }
    };
 
    laravel.initialize();
 
});
</script>
@endpush