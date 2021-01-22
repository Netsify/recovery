@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Форма предварительной онлайн регистрации
                    </div>

                    <div class="card-body">
                        @if(session()->has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session()->get('error') }}
                            </div>
                        @endif

                        <form action="{{ route('library.store') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="queue" class="form-label">{{ __('library.Queue') }}</label>
                                <select name="queue" class="form-select @error('queue') is-invalid @enderror">
                                    <option value="0" disabled>{{ __('library.SelectQueue') }}</option>
                                    @foreach($queues as $queue)
                                        <option value="{{ $queue->id }}">{{ $queue->name }}</option>
                                    @endforeach
                                </select>

                                @error('queue')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="queue" class="form-label">{{ __('library.Queue') }}</label>
                                <select name="queue" class="form-select @error('queue') is-invalid @enderror">
                                    <option value="0" disabled>{{ __('library.SelectQueue') }}</option>
                                    @foreach($queues as $queue)
                                        <option value="{{ $queue->id }}">{{ $queue->name }}</option>
                                    @endforeach
                                </select>



                                @error('queue')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('library.Save') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
