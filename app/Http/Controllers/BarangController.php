<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;
use App\Barang;
use Spatie\Permission\Models\Role;
use Iluminate\Support\Facades\DB;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang=\App\Barang::All();
        return view('admin.barang',['barang'=>$barang]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $tambah_barang=new \App\Barang;
        $tambah_barang->kd_brg = $request->addkdbrg;
        $tambah_barang->nm_brg = $request->addnmbrg;
        $tambah_barang->harga = $request->addharga;
        $tambah_barang->stok = $request->addstok;
        $tambah_barang->save();
        Alert::success('Pesan','Data Berhasil disimpan');
        return redirect()->route('barang.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $barang_edit = \App\Barang::findOrFail($id);
        return view('admin.editBarang',['barang'=>$barang_edit]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update_barang = \App\Barang::findOrFail($id);
        $update_barang->kd_brg=$request->get('addkdbrg');
        $update_barang->nm_brg=$request->get('addnmbrg');
        $update_barang->harga=$request->get('addharga');
        $update_barang->stok=$request->get('addstok');
        $update_barang->save();
        Alert::success('Update', 'Data Berhasil diupdate');
        return redirect()->route('barang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang=\App\Barang::findOrFail($id);
        $barang->delete();
        Alert::success('Pesan','Data berhasil dihapus');
        return redirect()->route('barang.index');
    }
}
