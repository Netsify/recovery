@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-14">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr align="center">
                                    <th scope="col">id</th>
                                    <th scope="col">ФИО</th>
                                    <th scope="col">ИИН</th>
                                    <th scope="col">Email в СДО</th>
                                    <th scope="col">Запрашиваемый Email</th>
                                    <th scope="col">Документы</th>
                                    <th scope="col">Дата</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($emailChangeRequests as $emailChangeRequest)
                                    <tr align="center">
                                        <td>{{ $emailChangeRequest->student_id }}</td>
                                        <td>{{ $emailChangeRequest->student->getFullName() }}</td>
                                        <td>{{ $emailChangeRequest->student->IIN }}</td>
                                        <td>{{ $emailChangeRequest->student->email }}</td>
                                        <td><strong>{{ $emailChangeRequest->email }}</strong></td>
                                        <td>
                                            @foreach($emailChangeRequest->documents as $document)
                                                <a href="{{ asset('/storage/' . $document->path) }}" download="{{ $document->name }}">{{ $document->name }}</a>
                                            @endforeach
                                        </td>
                                        <td>{{ $emailChangeRequest->created_at }}</td>
                                        <td>
                                            <form action="{{ route('admin.update', $emailChangeRequest->id) }}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="email" value="{{ $emailChangeRequest->email }}">
                                                <button class="btn btn-sm btn-outline-success" type="submit">Принять</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.destroy', $emailChangeRequest->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" type="submit">Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9">Нет заявок на рассмотрение</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
{{--                                {{ $students->links() }}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
