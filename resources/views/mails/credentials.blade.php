@component('mail::message')

<p>Логин:</p>
<p>Пароль:</p>

@component('mail::button', ['url' => 'sdo.kineu.kz'])
Перейти на сайт СДО
@endcomponent

Спасибо,<br>
{{ config('app.name') }}
@endcomponent
