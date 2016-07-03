@extends('beautymail::templates.minty')

@section('content')

    @include('beautymail::templates.minty.contentStart')
        <tr>
            <td class="title">
                {{ trans('emails.user.appointment-cancellation.hello-title', compact('userName')) }}
            </td>
        </tr>
        <tr>
            <td width="100%" height="10"></td>
        </tr>
        <tr>
            <td class="paragraph">
                {{ trans('emails.user.appointment-cancellation.hello-paragraph') }}
            </td>
        </tr>
        <tr>
            <td width="100%" height="25"></td>
        </tr>
        <tr>
            <td class="title">
                {{ trans('emails.user.appointment-cancellation.appointment-title') }}
            </td>
        </tr>
        <tr>
            <td width="100%" height="10"></td>
        </tr>
        <tr>
            <td class="paragraph">
                @include('emails.user.appointment-cancellation._appointment', compact('appointment'))
            </td>
        </tr>
        <tr>
            <td width="100%" height="25"></td>
        </tr>
        <tr>
            <td>
                @include('beautymail::templates.minty.button', ['text' => trans('emails.user.appointment-cancellation.button'), 'link' => route('user.agenda')])
            </td>
        </tr>
        <tr>
            <td width="100%" height="25"></td>
        </tr>
    @include('beautymail::templates.minty.contentEnd')

@stop