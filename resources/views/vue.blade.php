@extends('layouts.app')

@section('content')
<div id="test">
    <select name="" id="" @change="bar">
        <option value="a">a</option>
        <option value="b">b</option>
    </select>
    @{{ msg }}
</div>
@endsection