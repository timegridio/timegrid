@extends('app')

<style>
.user-row {
    margin-bottom: 14px;
}

.user-row:last-child {
    margin-bottom: 0;
}

.dropdown-user {
    margin: 13px 0;
    padding: 5px;
    height: 100%;
}

.dropdown-user:hover {
    cursor: pointer;
}

.table-user-information > tbody > tr {
    border-top: 1px solid rgb(221, 221, 221);
}

.table-user-information > tbody > tr:first-child {
    border-top: 0;
}

.table-user-information > tbody > tr > td {
    border-top: 0;
}
.toppad
{
    margin-top:20px;
}
</style>
@endsection

@section('content')
<div class="container">

    @include('flash::message')

    @if($errors->has())
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >

          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">{{ $contact->fullname }}</h3>
            </div>

            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=100" class="img-circle"> </div>
                
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                    <tr>
                        <td>{{ trans('manager.contacts.label.birthdate') }}</td>
                        <td>{{ $contact->birthdate }} ({{ $contact->age() }})</td>
                    </tr>
                    <tr>
                        <td>{{ trans('manager.contacts.label.notes') }}</td>
                        <td>{{ $contact->notes }}</td>
                    </tr>
                    <tr>
                        <td>Other</td>
                        <td>#</td>
                    </tr>
                   
                    <tr>
                      <tr>
                        <td>{{ trans('manager.contacts.label.gender') }}</td>
                        <td>{{ trans('app.gender.'.$contact->gender) }}</td>
                      </tr>
                        <tr>
                        <td>Home Address</td>
                        <td>#</td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td>#</td>
                      </tr>
                        <td>{{ trans('manager.contacts.label.mobile') }}</td>
                        <td>{{ $contact->mobile }}</td>
                    </tr>
                     
                    </tbody>
                  </table>
                  
                  <a href="#" class="btn btn-primary">Reservar Turno</a>
                  <a href="#" class="btn btn-primary">Contactar</a>
                </div>
              </div>
            </div>
                 <div class="panel-footer">
                        <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
                        <span class="pull-right">
                            <a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                            <a data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                        </span>
                 </div>
            
          </div>
        </div>
      </div>
    </div>
@endsection

@section('scripts')
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
</script>
@endsection