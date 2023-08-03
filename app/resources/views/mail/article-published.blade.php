@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
                        <div class="text">
                            <h2>{{ __('email.article_published_view_text_h2')}}</h2>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="text html-display">
                            {!! $article->content !!}
                        </div>
                        <div class="text-author"  style="text-align: center;">
                            <p><a href="{{ env('APP_URL') . '/main/'}}" class="btn btn-primary">{{ __('email.article_published_view_text_a')}}</a></p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
