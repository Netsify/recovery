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
                        <form action="{{ route('students.check') }}" method="POST">
                            @csrf
                            @if(session()->get('message') === (config('app.iin_failed')) ||
                                session()->get('message') === config('app.name_failed'))
                                <div class="form-group">
                                    @if(session()->get('message'))
                                        <div class="alert alert-danger d-flex align-items-center justify-content-center mb-2">
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif
                                </div>
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
                            @else
                                <div class="form-group">
                                    <label for="IIN">Введите ИИН</label>
                                    <input type="text" class="form-control" name="IIN" />
                                </div>
                            @endif

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Далее</button>
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
