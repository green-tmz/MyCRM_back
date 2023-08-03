@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
                        <div class="text">
                            @if (!empty($vacancy))
                                <h2>{{ __('email.candidate_view_text_new_request')}} {{$vacancy->name}}</h2>
                            @else
                                <h2>{{ __('email.candidate_view_text_new_request_vacancy')}}</h2>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <div class="text-author">
                            <p><a href="{{ $candidate->detail_url }}" class="btn btn-primary">{{ __('email.candidate_view_text_btn_candidate')}}</a></p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection