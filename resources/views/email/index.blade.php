@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-info mb-3">
                    <div class="card-header border-info">
                        <div class="d-flex align-items-center justify-content-center">
                            <strong>По запросу найдено</strong>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr align="center">
                                    <th scope="col">ФИО</th>
                                    <th scope="col">Группа</th>
                                    <th scope="col">Специальность</th>
                                    <th scope="col">Форма обучения</th>
                                    <th scope="col">Год поступления</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr align="center">
                                    <td>{{ $student->full_name }}</td>
                                    <td>{{ $student->getGroup() }}</td>
                                    <td>{{ $student->specialty->getFullSpecialty() }}</td>
                                    <td>{{ $student->educationform->name }}</td>
                                    <td>{{ $student->stud_post }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card border-info">
                    <div class="card-header border-info">
                        <div class="d-flex align-items-center justify-content-center">
                            Отправка пароля на почту
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger d-flex align-items-center justify-content-center mb-2">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
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
