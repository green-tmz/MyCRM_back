@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
                        <div class="text">
                            <h2>{{ $title }}</h2>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;" class="html-display">
                        <div class="text-author">
                            <h3 class="name">{{ $event->name }}</h3>
                            <h4>Время события: {{ $timeEvent }}</h4>
                            @if(!empty($recurrence))
                                <span class="position">{!! $recurrence !!}</span>
                            @endif
                            @if(!empty($description))
                            <span class="position">{!! $description !!}</span>
                            @endif
                            <p><a href="{{ env('APP_URL') . '/calendar/'}}" class="btn btn-primary">Перейти</a></p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
