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
                                @forelse($email_requests as $email_request)
                                    <tr align="center">
                                        <td>{{ $email_request->student_id }}</td>
                                        <td>{{ $email_request->student->getFullName() }}</td>
                                        <td>{{ $email_request->student->IIN }}</td>
                                        <td>{{ $email_request->student->email }}</td>
                                        <td><strong>{{ $email_request->email }}</strong></td>
                                        <td>
                                            @foreach($email_request->documents as $document)
                                                <a href="{{ asset('/storage/' . $document->path) }}" download="{{ $document->name }}">{{ $document->name }}</a>
                                            @endforeach
                                        </td>
                                        <td>{{ $email_request->created_at }}</td>
                                        <td>
                                            <form action="{{ route('admin.update', $email_request->id) }}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="email" value="{{ $email_request->email }}">
                                                <button class="btn btn-sm btn-outline-success" type="submit">Принять</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.destroy', $email_request->id) }}" method="post">
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
