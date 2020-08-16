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
                            <p>Ваши данные были успешно отправлены.</p>
                            <p>Мы рассмотрим Вашу заявку и отправим учетные данные по указанной почте.</p>
                            <p>Спасибо за использование системы восстановления паролей сайта
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
