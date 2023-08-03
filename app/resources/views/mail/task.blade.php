@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
                        <div class="text">
                            <h2>Уведомление о задаче</h2>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <div class="text-author">
                            <h3 class="name">{{ $task->name  }}</h3>
                            <span class="position">Перейдите по ссылке ниже, чтобы посмотреть подробности по ней.</span>
                            <p><a href="{{ $task->detail_url  }}" class="btn btn-primary">Перейти к задаче</a></p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
