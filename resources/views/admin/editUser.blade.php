@extends('layouts.layout')
@section('content')
@include('sweetalert::alert')
<form action="{{route('user.update', [$user->userid])}}" method="POST">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <fieldset>
        <legend>Rubah Data User</legend>
        <div class="form-group row">
            <div class="col-md-5">
                <label for="adduserid">User Id</label>
                <input class="form-control" type="text" name="addkdbrg" value="{{$user->userid}}" readonly>
            </div>
            <div class="col-md-5">
                <label for="addnmuser">Nama</label>
                <input id="addnmuser" type="text" name="addnmuser" class="form-control" value="{{$user->nm_user}}">
            </div>
            <div class="col-md-5">
                <label for="email">Email</label>
                <input id="email" type="text" name="email" class="form-control" value="{{$user->email}}">
            </div>
            <div class="col-md-5">
                <label for="pass">Password</label>
                <input id="pass" type="text" name="pass" class="form-control" value="{{$user->pass}}">
            </div>

            </fieldset>
            <div class="col-md-10">
                <input type="submit" class="btn btn-success btn-send" value="Update">
                <a href="{{ route('user.index') }}"><input type="Button" class="btn btn-primary btn-send" value="Kembali"></a>
            </div>
            <hr>
</form>
@endsection