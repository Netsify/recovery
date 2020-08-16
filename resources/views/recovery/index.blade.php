@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-info">
                    <div class="card-header border-info">
                        <div class="d-flex align-items-center justify-content-center">
                            Восстановление пароля
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            @if(!empty($message))
                                <div class="alert alert-success d-flex align-items-center justify-content-center mb-2">
                                    {{ $message }}
                                </div>
                            @endif
                        </div>
                        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                Ваш Email в системе: {{ $student->disguiseEmail() }}
                            </div>
                            <div class="form-group">
                                Если Вы забыли пароль от учетной записи, то Вы можете отправить нам заявку
                                на смену Email адреса, прикрепив удостоверение личности.
                            </div>
                            <div class="form-group">
                                <label for="email">Введите новый Email</label>
                                <input type="email" class="form-control" name="email" />
                            </div>
                            <label for="document">Прикрепите удостоверение личности</label>
                            <div class="form-group">
                                <input type="file" name="passport[]" multiple>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-info">Отправить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
