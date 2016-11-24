@extends('beautymail::templates.minty')

@section('content')

    @include('beautymail::templates.minty.contentStart')
        <tr>
            <td class="title">
                {{ trans('emails.user.appointment-validation.hello-title') }}
            </td>
        </tr>
        <tr>
            <td width="100%" height="10"></td>
        </tr>
        <tr>
            <td class="paragraph">
                {{ trans('emails.user.appointment-validation.hello-paragraph') }}
            </td>
        </tr>
        <tr>
            <td width="100%" height="25"></td>
        </tr>
        <tr>
            <td class="title">
                {{ trans('emails.user.appointment-validation.appointment-title') }}
            </td>
        </tr>
        <tr>
            <td width="100%" height="10"></td>
        </tr>
        <tr>
            <td class="paragraph">
                @include('emails.guest.appointment-validation._appointment', compact('appointment'))
            </td>
        </tr>
        <tr>
            <td width="100%" height="25"></td>
        </tr>
        <tr>
            <td>
                @include('beautymail::templates.minty.button', ['text' => trans('emails.user.appointment-validation.button'), 'link' => route('user.agenda')])
            </td>
        </tr>
        <tr>
            <td width="100%" height="25"></td>
        </tr>
    @include('beautymail::templates.minty.contentEnd')

@stop