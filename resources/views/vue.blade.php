@extends('layouts.app')

@section('content')
<div id="test">
    <input type="text" v-model="msg">
    @{{ msg }}
</div>
@endsection