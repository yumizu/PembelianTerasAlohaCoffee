<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Retur;
use App\DetailRetur;
use App\Pembelian;
use DB;
use Alert;
use App\DetailJurnal;

class ReturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembelian=\App\Pembelian::All(); 
        return view('retur.retur',['pembelian'=>$pembelian]);
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
        $AWAL = 'RTR';
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        $noUrutAkhir = \App\Retur::max('no_retur');
        $no = 1; 
        $format=sprintf("%03s", abs((int)$noUrutAkhir + 1)). '/' . $AWAL .'/' . $bulanRomawi[date('n')] .'/' . date('Y');
        //No otomatis untuk jurnal
        $AWALJurnal = 'JRU';
        $bulanRomawij = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        $noUrutAkhirj = \App\Jurnal::max('no_jurnal');
        $noj = 1;
        $formatj=sprintf("%03s", abs((int)$noUrutAkhirj + 1)). '/' . $AWALJurnal .'/' . $bulanRomawij[date('n')] .'/' . date('Y');  
        $decrypted = Crypt::decryptString($id);
        $detail      = DB::table('tampil_pembelian')->where('no_beli',$decrypted)->get();
        $pemesanan   = DB::table('pemesanan')->where('no_pesan',$decrypted)->get();
        $akunkas      = DB::table('setting')->where('nama_transaksi','Kas')->get();
        $akunretur    = DB::table('setting')->where('nama_transaksi','Retur')->get();
        return view('retur.beli',['beli'=>$detail,'format'=>$format,'no_pesan'=>$decrypted,'pemesanan'=>$pemesanan,'formatj'=>$formatj,'kas'=>$akunkas,'retur'=>$akunretur]);
}

public function simpan(Request $request)
{
    $this->validate($request, [
        'no_retur' => 'required',
        'tgl' => 'required',
    ]);
    if (count($request->jml_retur) > 0) {
        foreach($request->jml_retur as $jml) {
            if ($jml == 0) {
                return redirect()
                    ->back()
                    ->withInput($request->input())
                    ->withErrors(['error' => 'Jumlah retur tidak boleh kosong']);
            }
        }
    }
    if (Retur::where('no_retur', $request->no_retur)->exists()) {
        Alert::warning('Pesan ','Retur sudah dilakukan ');
        return redirect('retur');
    } else {
        DB::beginTransaction();
        try {
            //SIMPAN DATA KE TABEL DETAIL PEMBELIAN
            $kdbrg  = $request->kd_brg;
            $qtyretur = $request->jml_retur;
            $harga   = $request->harga;
            $nmbrg = $request->nm_brg;
            $total=0;


            //SIMPAN ke table jurnal bagian debet
            $tambah_jurnaldebet=new \App\Jurnal;
            $tambah_jurnaldebet->no_jurnal = $request->no_jurnal;
            $tambah_jurnaldebet->keterangan = 'Kas';
            $tambah_jurnaldebet->tgl_jurnal = $request->tgl;
            $tambah_jurnaldebet->no_akun = $request->kas;
            $tambah_jurnaldebet->debet = $total;
            $tambah_jurnaldebet->kredit = '0';
            $tambah_jurnaldebet->save();
            
            //SIMPAN ke table jurnal bagian kredit
            $tambah_jurnalkredit=new \App\Jurnal;
            $tambah_jurnalkredit->no_jurnal = $request->no_jurnal;
            $tambah_jurnalkredit->keterangan = 'Retur Pembelian';
            $tambah_jurnalkredit->tgl_jurnal = $request->tgl;
            $tambah_jurnalkredit->no_akun = $request->retur;
            $tambah_jurnalkredit->debet ='0';
            $tambah_jurnalkredit->kredit = $total;
            $tambah_jurnalkredit->save();

            foreach($kdbrg as $key => $no)
            {
                $input['no_retur']   = $request->no_retur;
                $input['kd_brg']    = $kdbrg[$key];
                $input['qty_retur']  = $qtyretur[$key];
                $input['sub_retur']  = $harga[$key]*$qtyretur[$key];
                DetailRetur::insert($input);
                $total=$harga[$key]*$qtyretur[$key];
                
                DetailJurnal::create([
                    'jurnal_id' => $tambah_jurnalkredit->id,
                    'no_jurnal' => $request->no_jurnal,
                    'kd_brg' => $kdbrg[$key],
                    'nm_brg' => $nmbrg[$key],
                    'qty' => $qtyretur[$key],
                    'subtotal' => $harga[$key]*$qtyretur[$key],
                ]);
            }
            //Simpan ke table retur
            $tambah_pembelian=new \App\Retur;
            $tambah_pembelian->no_retur = $request->no_retur;
            $tambah_pembelian->tgl_retur = $request->tgl;
            $tambah_pembelian->total_retur = $total;
            $tambah_pembelian->save();

            DB::commit();
            Alert::success('Pesan ','Data berhasil disimpan');
        } catch(\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        
        return redirect('/retur');
    }
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
    public function destroy(Request $request)
    {
        $no_faktur = $request->no_faktur;
        $pembelian = \App\Pembelian::where('no_beli', $no_faktur)->first();
        if($pembelian) {
            $detail = \App\DetailPembelian::where('no_beli', $pembelian->no_beli)->first();
            if($detail) {
                $detail->delete();
            }
            $pembelian->delete();
        }
        return [
            'success' => true
        ];
    }
}
