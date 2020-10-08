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
                        @if(!empty(session('message')))
                            <div class="alert alert-danger d-flex align-items-center justify-content-center mb-2">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form action="{{ route('students.send') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email">Введите Email</label>
                                <input type="email" class="form-control" name="email" />
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Получить пароль</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
