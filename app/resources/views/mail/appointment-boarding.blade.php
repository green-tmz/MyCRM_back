@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
                        <div class="text">
                            <h2>{{ $user->full_name }}, Вам назначен {{ mb_strtolower($boarding->typeData->name) }}</h2>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <div class="text-author">
                            <h3 class="name">{{ $boarding->name  }}</h3>
                            <span class="position">Перейдите по ссылке ниже, чтобы посмотреть подробности по нему.</span>
                            <p><a href="{{ request()->getSchemeAndHttpHost() }}/profile/{{ $user->id }}/{{ $boarding->typeData->code }}" class="btn btn-primary">Перейти</a></p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
