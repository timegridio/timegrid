@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $humanresource->name }}</h3>
                </div>

                <ul class="list-group">
                    <li class="list-group-item">
                        {{ $humanresource->slug }}
                    </li>
                </ul>

                <div class="panel-body">
                    <p>{{ $humanresource->capacity }}</p>
                </div>

                <div class="panel-footer">
                    {!! Button::normal()
                        ->withIcon(Icon::edit())
                        ->asLinkTo(route('manager.business.humanresource.edit', [$humanresource->business, $humanresource->id]) ) !!}

                        {!! Button::danger()->withIcon(Icon::trash())->withAttributes([
                            'type' => 'button',
                            'data-toggle' => 'tooltip',
                            'data-original-title' => trans('manager.humanresource.btn.delete'),
                            'data-method' => 'DELETE',
                            'data-confirm' => trans('manager.humanresource.btn.delete').'?']
                        )->asLinkTo( route('manager.business.humanresource.destroy', [$humanresource->business, $humanresource]) ) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')
<script>
$(document).ready(function() {
        var panels = $('.user-infos');
        var panelsButton = $('.dropdown-user');
        panels.hide();

        //Click dropdown
        panelsButton.click(function() {
                //get data-for attribute
                var dataFor = $(this).attr('data-for');
                var idFor = $(dataFor);

                //current button
                var currentButton = $(this);
                idFor.slideToggle(400, function() {
                        //Completed slidetoggle
                        if(idFor.is(':visible'))
                        {
                                currentButton.html('<i class="glyphicon glyphicon-chevron-up text-muted"></i>');
                        }
                        else
                        {
                                currentButton.html('<i class="glyphicon glyphicon-chevron-down text-muted"></i>');
                        }
                })
        });


        $('[data-toggle="tooltip"]').tooltip();

        $('button').click(function(e) {
                e.preventDefault();
                alert("This is a demo.\n :-)");
        });
});

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
 
            return form.append(token, hiddenInput)
                                 .appendTo('body');
        }
    };
 
    laravel.initialize();
 
})();
</script>
@endsection