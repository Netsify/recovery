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
{{--                        {{ route('students.email') }}--}}
                        <form action="" method="POST">
                            @csrf
                            <div class="form-group">
                                @if(session()->get('message'))
                                    <div class="alert alert-danger d-flex align-items-center justify-content-center mb-2">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">Введите Email</label>
                                <input type="email" class="form-control" name="email" />
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Отправить</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-sm-8 offset-sm-2">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger d-flex align-items-center justify-content-center mb-2">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
