<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use App\Supplier;
use App\Pemesanan;
use App\Pemesanan_tem;
use App\Temp_pesan;
use DB;
use App\Jurnal;
use App\Retur;
use App\DetailRetur;
use Alert;

class PemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $akun=\App\Akun::All();
        $barang=\App\Barang::All();
        $supplier=\App\Supplier::All();
        $temp_pesan=\App\Temp_pesan::All();
        //No otomatis untuk transaksi pemesanan
        $AWAL = 'TRX';
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        $noUrutAkhir = \App\Pemesanan::max('no_pesan');
        $no = 1;
        $formatnya=sprintf("%03s", abs((int)$noUrutAkhir + 1)). '/' . $AWAL .'/' . $bulanRomawi[date('n')] .'/' . date('Y');
        return view('pemesanan.pemesanan' ,
                    ['barang' => $barang,
                    'akun' => $akun,
                    'supplier'=>$supplier,
                    'temp_pemesanan'=>$temp_pesan,
                    'formatnya'=>$formatnya]);
    }
    public function tambahOrder()
    {
        return view('pemesanan');
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
        //Validasi jika barang sudah ada pada tabel temporari maka QTY akaan di edit
        if (Pemesanan_tem::where('kd_brg', $request->brg)->exists()) {
            Alert::warning('Pesan ','barang sudah ada.. QTY akan terupdate ?');
            Pemesanan_tem::where('kd_brg', $request->brg)
                            ->update(['qty_pesan' => $request->qty]);
            return redirect('transaksi');
        }else{
            Pemesanan_tem::create([
                'qty_pesan' => $request->qty,
                'kd_brg' => $request->brg
            ]);
        return redirect('transaksi');
}
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
    public function destroy($kd_brg)
    {
        $barang = \App\Pemesanan_tem::where('kd_brg', $kd_brg)->first();
        if ($barang) {
            $barang->delete();
        }
        $tampPembelian = DB::table('detail_pembelian')->where('kd_brg',$kd_brg);
        if ($tampPembelian) {
            $tampPembelian->delete();
        }
        Alert::success('Pesan ','Data berhasil dihapus');
        return redirect('transaksi');
    }

}
