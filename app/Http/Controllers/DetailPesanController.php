<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetailPesan;
use App\Pemesanan;
use Alert;

class DetailPesanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function simpan (Request $request)
    {
        if (isset($request->kd_brg) == false) {
            return redirect()
                ->back()
                ->withInput($request->input())
                ->withErrors(['barang' => 'Input data barang terlebih dahulu']);
        }
        //Simpan ke table pemesanan
        $tambah_pemesanan=new \App\Pemesanan;
        $tambah_pemesanan->no_pesan = $request->no_pesan;
        $tambah_pemesanan->tgl_pesan = $request->tgl;
        $tambah_pemesanan->total = $request->total;
        $tambah_pemesanan->kd_supp = $request->supp;
        $tambah_pemesanan->save();
        //SIMPAN DATA KE TABEL DETAIL
        $kd_brg = $request->kd_brg;
        $qty= $request->qty_pesan;
        $sub_total= $request->sub_total;
        foreach($kd_brg as $key => $no)
        {
            $input['no_pesan'] = $request->no_pesan;
            $input['kd_brg'] = $kd_brg[$key];
            $input['qty_pesan'] = $qty[$key];
            $input['subtotal'] = $sub_total[$key];
            DetailPesan::insert($input); 
        }
                Alert::success('Pesan ','Data berhasil disimpan');
        return redirect('/transaksi');

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
