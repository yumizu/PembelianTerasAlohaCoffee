@extends('layouts.layout')
@section('content')
@include('sweetalert::alert')
<form action="{{route('user.update', [$user->id])}}" method="POST">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <fieldset>
        <legend>Ubah Data User</legend>
        <div class="form-group row">
            <div class="col-md-5">
                <label for="adduserid">User Id</label>
                <input class="form-control" type="text" name="id" value="{{$user->id}}" readonly>
            </div>
            <div class="col-md-5">
                <label for="addnmuser">Nama</label>
                <input id="name" type="text" name="name" class="form-control" value="{{$user->name}}">
            </div>
            <div class="col-md-5">
                <label for="email">Email</label>
                <input id="email" type="text" name="email" class="form-control" value="{{$user->email}}">
            </div>
            <div class="col-md-5">
                <label for="pass">Password</label>
                <input id="password" type="password" name="password" class="form-control">
            </div>
            <div class="col-md-5">
                <label for="pass">Role</label>
                <select id="roles" name="roles" class="form-control" required>
                    <option value="">--Pilih Roles--</option>
                    <option value="1" {{ $user->roles->pluck('id')->first() == 1 ? 'selected' : '' }}>Admin</option>
                    <option value="2" {{ $user->roles->pluck('id')->first() == 2 ? 'selected' : '' }}>User</option>
                </select>
            </div>

            </fieldset>
            <div class="col-md-10">
                <input type="submit" class="btn btn-success btn-send" value="Update">
                <a href="{{ route('user.index') }}"><input type="Button" class="btn btn-primary btn-send" value="Kembali"></a>
            </div>
            <hr>
</form>
@endsection