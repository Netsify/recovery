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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $document)
                                    <tr align="center">
                                        <td>{{ $document->student_id }}</td>
                                        <td>{{ $document->student->getFullName() }}</td>
                                        <td>{{ $document->student->IIN }}</td>
                                        <td>{{ $document->student->email }}</td>
                                        <td>{{ $document->requested_email }}</td>
                                        <td>
                                            <a href="{{ asset('/storage/' . $document->path) }}" download="{{ $document->name }}">{{ $document->name }}</a>
                                        </td>
                                        <td>{{ $document->created_at }}</td>
                                        <td>
                                            <form action="{{ route('admin.update', $document->student_id) }}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="email" value="{{ $document->requested_email }}">
                                                <button class="btn btn-danger" type="submit">Принять</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.destroy', $document->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
{{--                                {{ $students->links() }}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
