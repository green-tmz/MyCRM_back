@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
                        <div class="text">
                            <h2>{{ __('email.objective_view_text_update')}}</h2>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <div class="text-author">
                            {{ __('email.objective_view_text_to_objective')}} <h3 class="name">{{ $objective->name }}</h3> {{ __('email.objective_view_text_add_update')}}
                            <p><a href="{{ $objective->detail_url  }}" class="btn btn-primary">{{ __('email.objective_view_text_btn')}}</a></p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
