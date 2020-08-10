@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-info">
                    <div class="card-header border-info">
                        <div class="d-flex align-items-center justify-content-center">
                            Отправка пароля на почту
                        </div>
                    </div>

                    <div class="card-body">
                        Ваши учетные данные были успешно отправлены. Сообщите в чат технической поддержки,
                        если данное письмо попало в папку "Спам" или Вы столкнулись с другими проблемами.
                        Спасибо за использование системы генерации паролей сайта
                        системы дистанционного обучения КИнЭУ им. М. Дулатова.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
