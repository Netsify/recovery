@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr align="center">
                                    <th scope="col">id</th>
                                    <th scope="col">ФИО</th>
                                    <th scope="col">ИИН</th>
                                    <th scope="col">Почта</th>
                                    <th scope="col">Документы</th>
                                    <th scope="col">Дата</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $document)
                                    <tr align="center">
                                        <td>{{ $document->stud_id }}</td>
                                        <td>{{ $document->student->getFullName() }}</td>
                                        <td>{{ $document->student->IIN }}</td>
                                        <td>{{ $document->student->email }}</td>
                                        <td>
                                            <a href="{{ $document->path }}" download="{{ $document->path }}">Скачать</a>
                                        </td>
                                        <td>{{ $document->created_at }}</td>
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
