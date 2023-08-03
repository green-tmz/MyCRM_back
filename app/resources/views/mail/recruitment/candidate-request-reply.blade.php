@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
                        <div class="text-author">
                            @if (!empty($content))
                                {!! $content !!}
                            @else
                                <h2>{{ __('email.candidate_view_text_new_request_reply')}}</h2>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection