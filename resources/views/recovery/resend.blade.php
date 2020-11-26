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
                                    <td>{{ $full_name }}</td>
                                    <td>{{ $group }}</td>
                                    <td>{{ $specialty }}</td>
                                    <td>{{ $education_form }}</td>
                                    <td>{{ $admission_year }}</td>
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
                        <div class="form-group">
                            Ваш Email в системе: <strong>{{ $disguised_email }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <form action="{{ route('students.send') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-info">Отправить</button>
                            </form>
{{--                            <form action="{{ route('students.recovery') }}" method="GET">--}}
{{--                                <input type="hidden" name="IIN" value="{{ $IIN }}">--}}
{{--                                <button type="submit" class="btn btn-success">Заявка на смену почты</button>--}}
{{--                            </form>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
