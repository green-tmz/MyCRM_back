@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
                        <div class="text">
                            @if ($isSuccess)
                                <h2>Заявка выполнена</h2>
                            @else
                                <h2>Заявка отклонена</h2>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <div class="text-author">
                            @if ($isSuccess)
                                Ваша заявка #{{ $requestId }}:<strong>{{ $requestName }}</strong> выполнена.
                                @if ($needFeedback)
                                    Оставьте, пожалуйста, обратную связь.
                                @endif
                            @else
                                Ваша заявка #{{ $requestId }}:<strong>{{ $requestName }}</strong> отклонена.
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
