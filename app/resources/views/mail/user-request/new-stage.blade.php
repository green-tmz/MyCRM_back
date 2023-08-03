@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
                        <div class="text">
                            @if ($isNew)
                                <h2>Создана новая заявка</h2>
                            @else
                                <h2>Заявка перешла на следующий этап</h2>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <div class="text-author">
                            @if ($isNew)
                                Создана заявка #{{ $requestId }}:<strong>{{ $requestName }}</strong>.
                                Вы назначены {{ $role }} по этапу заявки
                                <strong>{{ $stageName }}</strong>.
                            @else
                                Заявка #{{ $requestId }}:<strong>{{ $requestName }}</strong>
                                перешла на этап <strong>{{ $stageName }}</strong>.
                                Вы назначены {{ $role }} по этапу.
                            @endif
                            <br>
                            <p><a href="{{ $detailUrl  }}" class="btn btn-primary">{{ __('email.user_request_view_text_btn')}}</a></p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
