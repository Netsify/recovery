@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-primary">
                    <div class="card-header border-info">
                        <div class="d-flex align-items-center justify-content-center">
                            Получение пароля в СДО
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('students.check_iin') }}" method="POST">
                            @csrf

                            @if(!empty($message))
                                <div class="alert alert-danger d-flex align-items-center justify-content-center mb-2">
                                    {{ $message }}
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="IIN">Введите ИИН</label>
                                <input type="text" class="form-control" name="IIN" required />
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Далее</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
