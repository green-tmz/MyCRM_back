@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
                        <div class="text">
                            <h2>{{ __('email.evaluation_view_start_response')}}</h2>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <div class="text-author">
                            {{ __('email.evaluation_view_required_response')}}
                            <h3 class="name">{{ $evaluation->name  }}</h3>
                            <span class="position">
                                {{ __('email.evaluation_view_finish_date_response')}}
                                <strong>{{$evaluation->date_response_format}}</strong>
                            </span>
                            <br>
                            <span class="position">
                                {{ __('email.evaluation_view_period')}}
                                <strong>{{$evaluation->period_start_format}} - {{$evaluation->period_end_format}}</strong>
                            </span>
                            <p>
                                {!! $evaluation->text_email !!}
                                <a href="{{ $evaluation->detail_url  }}" class="btn btn-primary">{{ __('email.evaluation_view_btn')}}</a>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
