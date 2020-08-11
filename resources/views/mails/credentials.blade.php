@component('mail::message')

<p>Логин: <strong>{{ $student->stud_login }}</strong></p>
<p>Пароль: <strong>{{ $student->stud_passwd }}</strong></p>

@component('mail::button', ['url' => 'sdo.kineu.kz'])
Перейти на сайт
@endcomponent

Спасибо, система генерации паролей
@endcomponent
