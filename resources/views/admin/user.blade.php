@extends('layouts.layout')
@section('content')
@include('sweetalert::alert')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> Data Pengguna </h1>
</div>
<hr>
<div class="card-header py-3" align="right">
    <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-add"><i
            class="fa fa-plus"></i>Tambah</button>
</div>
<div class="d-sm-flex align-items-center justify-content-between mb-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr align="center">
                        <th width="5%">No</th>
                        <th width="20%">Nama</th>
                        <th width="20%">Email</th>
                        <th width="15%">Roles/Akses</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $number = 0;
                    @endphp
                    @foreach($user as $row)
                        @php
                            $number += 1;
                        @endphp
                        <tr>
                            <td>{{ $number }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            @if(count($row->roles) == 0))
                                <td>-</td>
                            @else
                                @foreach($row->roles as $r)
                                    <td>
                                        {{ $r->name }}
                                    </td>
                                @endforeach
                            @endif
                            <td align="center">
                                <a href="{{ route( 'user.edit' ,[$row->id]) }}"
                                    class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                                    <i class="fas fa-edit fa-sm text-white-50"></i>Edit
                                </a>
                                <a href="/user/hapus/{{ $row->id }}"
                                    onclick="return confirm('Yakin Ingin menghapus data?')"
                                    class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                    <i class="fas fa-trash-alt fa-sm text-white-50"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- modal add data-->
<div class="modal inmodal fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xs">
        <form name="frm_add" id="frm_add" class="form-horizontal" action="#" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data User</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group"><label class="col-lg-20 control-label">Nama User</label>
                        <div class="col-lg-10"><input type="text" name="username" required class="form-control"></div>
                        <div class="form-group"><label class="col-lg-20 control-label">Email User</label>
                            <div class="col-lg-10"><input type="email" name="email" required class="form-control"></div>
                            <div class="form-group"><label class="col-lg-20 control-label">Roles/Akses</label>
                                <div class="col-lg-10">
                                    <select id="roles" name="roles" class="form-control" required>
                                        <option value="">--Pilih Roles--</option>
                                        <option value="ADMIN">Admin</option>
                                        <option value="USER">User</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        @endsection
                    </div>
        </form>
    </div>
</div>
