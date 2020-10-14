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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    <tr align="center">
                                        <th scope="row">{{$student->stud_id}}</th>
                                        <td>{{$student->stud_login}}</td>
                                        <td>{{$student->IIN}}</td>
                                        <td>{{$student->course}}</td>
                                        <td>{{$student->email}}</td>
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
