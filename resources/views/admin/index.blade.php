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
{{--                                @foreach($documents as $document)--}}
{{--                                    <tr align="center">--}}
{{--                                        <td>{{ $document->student_id }}</td>--}}
{{--                                        <td>{{ $document->student->getFullName() }}</td>--}}
{{--                                        <td>{{ $document->student->IIN }}</td>--}}
{{--                                        <td>{{ $document->student->email }}</td>--}}
{{--                                        <td><strong>{{ $document->requested_email }}</strong></td>--}}
{{--                                        <td>--}}
{{--                                            <a href="{{ asset('/storage/' . $document->path) }}" download="{{ $document->name }}">{{ $document->name }}</a>--}}
{{--                                        </td>--}}
{{--                                        <td>{{ $document->created_at }}</td>--}}
{{--                                        <td>--}}
{{--                                            <form action="{{ route('admin.update', $document->id) }}" method="post">--}}
{{--                                                @csrf--}}
{{--                                                @method('PATCH')--}}
{{--                                                <input type="hidden" name="student_id" value="{{ $document->student_id }}">--}}
{{--                                                <input type="hidden" name="email" value="{{ $document->requested_email }}">--}}
{{--                                                <button class="btn btn-success" type="submit">Принять</button>--}}
{{--                                            </form>--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            <form action="{{ route('admin.destroy', $document->id) }}" method="post">--}}
{{--                                                @csrf--}}
{{--                                                @method('DELETE')--}}
{{--                                                <button class="btn btn-danger" type="submit">Удалить</button>--}}
{{--                                            </form>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
                                @foreach($students as $student)
                                    <tr align="center">
                                        <td>{{ $student->stud_id }}</td>
                                        <td>{{ $student->getFullName() }}</td>
                                        <td>{{ $student->IIN }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td><strong>{{ $student->documents->first()->requested_email }}</strong></td>
                                        <td>
                                            @foreach($student->documents as $document)
                                                 <a href="{{ asset('/storage/' . $document->path) }}" download="{{ $document->name }}">{{ $document->name }}</a>
                                            @endforeach
                                        </td>
{{--                                        <td>{{ $student->documents->created_at }}</td>--}}
                                        <td>
{{--                                            <form action="{{ route('admin.update', $student->documents->id) }}" method="post">--}}
{{--                                                @csrf--}}
{{--                                                @method('PATCH')--}}
{{--                                                <input type="hidden" name="student_id" value="{{ $student->documents->student_id }}">--}}
{{--                                                <input type="hidden" name="email" value="{{ $student->documents->requested_email }}">--}}
{{--                                                <button class="btn btn-success" type="submit">Принять</button>--}}
{{--                                            </form>--}}
                                        </td>
                                        <td>
{{--                                            <form action="{{ route('admin.destroy', $student->documents->id) }}" method="post">--}}
{{--                                                @csrf--}}
{{--                                                @method('DELETE')--}}
{{--                                                <button class="btn btn-danger" type="submit">Удалить</button>--}}
{{--                                            </form>--}}
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
