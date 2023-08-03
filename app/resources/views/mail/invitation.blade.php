@extends('layouts.mail')

@section('content')
    <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table>
                <tr>
                    <td>
                        <div class="text" style="padding: 0 2.5em; text-align: center;">
                            <h2>Привет, {{ $user->full_name }}</h2>
                            <h3>Ваша компания отправила вам приглашение в МояКоманда.</h3>
                            <p><b>Эл. почта</b> {{ $user->email }}</p>
                            <p>Пожалуйста, нажмите на ссылку ниже, чтобы создать пароль к своей учетной записи.</p>
                            <p>
                                <a href="{{ $linkForResetPassword }}" class="btn btn-primary">Создать пароль</a>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection

@section('footer')
    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
        <tr>
            <td valign="middle" class="bg_light footer email-section">
                <table>
                    <tr>
                        <td valign="top" width="50%" style="padding-top: 20px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="text-align: left; padding-right: 10px;">
                                        <h3 class="heading">МояКоманда</h3>
                                        <p>Система для объединения сотрудников компании и повышения эффективности работы.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td valign="top" width="50%" style="padding-top: 20px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="text-align: left; padding-left: 5px; padding-right: 5px;">
                                        <h3 class="heading">Контактная информация</h3>
                                        <ul>
                                            <li><span class="text">Магнитогорск, ул. Ленина, д.94а БЦ «Арион»</span></li>
                                            <li><a href="tel:73519546630"><span class="text">+7 3519 54-66-30</span></a></li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection