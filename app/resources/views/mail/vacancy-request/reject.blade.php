@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
                        <div class="text">
                            <h2>Заявка на вакансию</h2>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <div class="text-author">
                            Ваша заявка на вакансию отклонена
                            <br>
                            <span class="position">
                                <strong>{{ $vacancyRequest->name }}</strong>
                            </span>
                            <p><a href="{{ $detailUrl  }}" class="btn btn-primary">Перейти к заявке на вакансию</a></p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
