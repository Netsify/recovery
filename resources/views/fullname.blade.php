@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-info">
                    <div class="card-header border-info">
                        <div class="d-flex align-items-center justify-content-center">
                            Получение пароля в СДО
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('students.check_fullname') }}" method="GET">
                            @if ($errors->any())
                                <div class="alert alert-danger d-flex align-items-center justify-content-center mb-2">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @elseif(session()->has('message'))
                                <div class="alert alert-danger d-flex align-items-center justify-content-center mb-2">
                                     {{ session('message') }}
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="first_name">Введите фамилию</label>
                                <input type="text" class="form-control" name="first_name" />
                            </div>
                            <div class="form-group">
                                <label for="middle_name">Введите имя</label>
                                <input type="text" class="form-control" name="middle_name" />
                            </div>
                            <div class="form-group">
                                <label for="last_name">Введите отчество</label>
                                <input type="text" class="form-control" name="last_name" />
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="/" type="button" class="btn btn-success">Назад</a>
                                <button type="submit" class="btn btn-primary">Далее</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
