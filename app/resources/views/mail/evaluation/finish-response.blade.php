@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="text-align: center;">
                        <div class="text-author">
                            <span class="position">
                               {{ __('email.evaluation_view_finish_response')}}
                                <strong>{{$evaluation->name}}</strong>
                            </span>
                            <p>
                                <a href="{{ $evaluation->url }}" class="btn btn-primary">{{ __('email.evaluation_view_btn')}}</a>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
