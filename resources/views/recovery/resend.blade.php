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
                                    <td>{{ $student->getFullName() }}</th>
                                    <td>{{ $student->getGroup() }}</th>
                                    <td>{{ $student->specialty->getFullSpecialty() }}</th>
                                    <td>{{ $student->educationform->name }}</th>
                                    <td>{{ $student->stud_post }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card border-info">
                    <div class="card-header border-info">
                        <div class="d-flex align-items-center justify-content-center">
                            Повторная отправка пароля
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
                                Ваш Email в системе: <strong>{{ $student->disguiseEmail() }}</strong>
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
