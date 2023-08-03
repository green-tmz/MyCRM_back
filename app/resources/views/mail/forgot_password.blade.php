@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table>
                <tr>
                    <td>
                        <div class="text" style="padding: 0 2.5em; text-align: center;">
                            <h2>{{__('email.forgot_password_view_text_h2')}}{{ $user->full_name }}</h2>
                            <h3>{{ __('email.forgot_password_view_text_h3')}}</h3>
                            <p>
                                <a href="{{ $linkForResetPassword }}" class="btn btn-primary"> {{__('email.forgot_password_view_text_a')}}</a>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection