@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-info">
                    <div class="card-header border-info">
                        <div class="d-flex align-items-center justify-content-center">
                            Повторная отправка пароля
                        </div>
                    </div>

                    <div class="card-body">
                        @if (!empty(session('message')))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach (session('message')->all() as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('students.send') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                Ваш Email в системе: <strong>{{ session('student')->disguiseEmail() }}</strong>
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