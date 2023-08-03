@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
                        <div class="text">
                            <h2>Опубликован новый опрос</h2>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="text html-display">
                            <div class="text" style="margin-top: 10px; text-align: center;">
                                <h3>{{ $question->name }}</h3>
                                <span class="position">Перейдите по ссылке ниже, чтобы поучаствовать в опросе.</span>
                                <p>
                                    <a href="{{ $linkDetail }}" class="btn btn-primary">
                                        Пройти опрос на сайте
                                    </a>
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
