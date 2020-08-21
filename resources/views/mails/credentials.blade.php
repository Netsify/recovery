@component('mail::message')

<p>Логин: <strong>{{ $student->stud_login }}</strong></p>
<p>Пароль: <strong>{{ $student->stud_passwd }}</strong></p>
<p>Сайт: sdo.kineu.kz/?login={{$student->stud_login}}</p>

@component('mail::button', ['url' => "sdo.kineu.kz/?login=$student->stud_login"])
Перейти на сайт
@endcomponent

Если письмо не попало в папку «Входящие» - пожалуйста, сообщите об этом в техническую поддержку.
@endcomponent