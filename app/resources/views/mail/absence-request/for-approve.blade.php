@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
                        <div class="text">
                            <h2>{{ __('email.absence_request_view_text')}}</h2>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <div class="text-author">
                            {{ __('email.absence_request_view_text_employee')}} <strong> {{$userName}} </strong> {{ __('email.absence_request_view_text_request')}}
                            <br>
                            <span class="position">
                                {{ __('email.absence_request_view_text_type')}}
                                <strong>{{$absenceType}}</strong>
                            </span>
                            <br>
                            <span class="position">
                                {{ __('email.absence_request_view_text_date')}}
                                <strong>{{$dateStart}} - {{$dateFinish}}</strong>
                            </span>
                            @if(!empty($comment))
                                <br>
                                <span class="position">
                                    {{ __('email.absence_request_view_text_comment')}}
                                    <strong>{{$comment}}</strong>
                                </span>
                            @endif
                            <p><a href="{{ $detailUrl  }}" class="btn btn-primary">{{ __('email.absence_request_view_text_btn')}}</a></p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
