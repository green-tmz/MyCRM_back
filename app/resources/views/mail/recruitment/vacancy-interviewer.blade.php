@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
                        <div class="text">
                            <h2>{{ __('email.vacancy_view_text_vacancy')}}</h2>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <div class="text-author">
                            {{ __('email.vacancy_view_text_you_interview')}} <h3 class="name">{{ $vacancy->name }}</h3>
                            <p>{{ __('email.vacancy_view_text_candidate')}} <a href="{{ $candidate->detail_url  }}">{{ $candidate->full_name }}</a> {{ __('email.vacancy_view_text_candidate_cycle')}}</p>
                            <p><a href="{{ $vacancy->detail_url  }}" class="btn btn-primary">{{ __('email.vacancy_view_text_to_vacancy')}}</a></p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
