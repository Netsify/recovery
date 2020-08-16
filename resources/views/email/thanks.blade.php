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
                        <div class="form-group">
                            <p>Ваши учетные данные были успешно отправлены.</p>
                            <p>Сообщите в чат технической поддержки, если данное письмо попало в папку "Спам"
                                или Вы столкнулись с другими проблемами.</p>
                            <p>Если у Вас нет доступа к почте, то воспользуйтесь сервисом еще раз.</p>
                            <p>Спасибо за использование системы генерации паролей сайта
                                системы дистанционного обучения КИнЭУ им. М. Дулатова.</p>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="/" type="button" class="btn btn-primary">На главную</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
