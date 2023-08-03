@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
                        <div class="text">
                            <h2>{{ __('email.kpi_view_text_add_comment')}}</h2>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <div class="text-author">
                            {{ __('email.kpi_view_text_to_kpi')}} <h3 class="name">{{ $kpi->name }}</h3> {{ __('email.kpi_view_text_new_comment')}}
                            <p><a href="{{ $kpi->detail_url  }}" class="btn btn-primary">{{ __('email.kpi_view_text_btn')}}</a></p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
