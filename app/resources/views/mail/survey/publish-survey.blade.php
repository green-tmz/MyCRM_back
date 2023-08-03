@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
                        <div class="text">
                            <h2>{{ __('email.survey_view_text_new_survey')}}</h2>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <div class="text-author">
                            @if($type == 'first')
                                {!! $survey->first_remind_content !!}
                            @elseif($type == 'last')
                                {!! $survey->last_remind_content !!}
                            @else
                                @if(!empty($survey->letter_content))
                                    {!! $survey->letter_content !!}
                                @endif
                            @endif
                                {{ __('email.survey_view_text_request')}} <h3 class="name">{{ $survey->name }}</h3>
                            <p><a href="{{ $survey->detail_url  }}?token={{ $token }}" class="btn btn-primary">{{ __('email.survey_view_text_to_survey')}}</a></p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
