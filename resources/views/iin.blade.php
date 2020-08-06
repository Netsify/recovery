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
                            <div class="form-group">
                                @if(session()->get('message'))
                                    <div class="alert alert-danger d-flex align-items-center justify-content-center mb-2">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="IIN">Введите ИИН</label>
                                <input type="text" class="form-control" name="IIN" />
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
