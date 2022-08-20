<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\DetailPembelian;
use App\Pembelian;
use App\Pemesanan_tem;
use App\Temp_pesan;
use App\Jurnal;
use DB;
use Alert;
use App\DetailJurnal;
use Illuminate\Support\Facades\DB as FacadesDB;
use PDF;
use Pemesanan;
use Carbon\Carbon;

class PembelianController extends Controller
{
    //
    public function index()
    {
        $pesan = \App\Pemesanan::All();
        $pesan = DB::select('SELECT * FROM pemesanan where not exists (select * from pembelian where pemesanan.no_pesan=pembelian.no_pesan)');
        return view('pembelian.pembelian', ['pemesanan' => $pesan]);
    }

    public function periodeLaporan()
    {
        return view('laporan.periode_pembelian');
    }

    public function edit($id)
    {
        $AWAL = 'FKT';
        $bulanRomawi = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $noUrutAkhir = \App\Pembelian::max('no_beli');
        $no = 1;
        $format = sprintf("%03s", abs((int)$noUrutAkhir + 1)) . '/' . $AWAL . '/' . $bulanRomawi[date('n')] . '/' . date('Y');
        $AWALJurnal = 'JRU';
        $bulanRomawij = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $noUrutAkhirj = \App\Jurnal::max('no_jurnal');
        $noj = 1;
        $formatj = sprintf("%03s", abs((int)$noUrutAkhirj + 1)) . '/' . $AWALJurnal . '/' . $bulanRomawij[date('n')] . '/' . date('Y');
        $decrypted = Crypt::decryptString($id);
        $detail = DB::table('tampil_pemesanan')->where('no_pesan', $decrypted)->get();
        $pemesanan = DB::table('pemesanan')->where('no_pesan', $decrypted)->get();
        $akunkas = DB::table('setting')->where('nama_transaksi', 'Kas')->get();
        $akunpembelian = DB::table('setting')->where('nama_transaksi', 'Pembelian')->get();
        return view('pembelian.beli', ['detail' => $detail, 'format' => $format, 'no_pesan' => $decrypted, 'pemesanan' => $pemesanan, 'formatj' => $formatj, 'kas' => $akunkas, 'pembelian' => $akunpembelian]);
    }
    public function pdf($id)
    {
        $decrypted = Crypt::decryptString($id);
        $detail = DB::table('tampil_pemesanan')->where('no_pesan', $decrypted)->get();
        $supplier = DB::table('supplier')->get();
        $pemesanan = DB::table('pemesanan')->where('no_pesan', $decrypted)->get();
        $pdf = PDF::loadView('laporan.faktur', ['detail' => $detail, 'order' => $pemesanan, 'supp' => $supplier, 'noorder' => $decrypted]);
        return $pdf->stream();
    }
    public function simpan(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'no_faktur' => 'required',
            'no_pesan' => 'required',
            'tgl' => 'required',
            'kd_brg' => 'required'
        ]);
        if (Pembelian::where('no_pesan', $request->no_pesan)->exists()) {
            Alert::warning('Pesan ', 'Pembelian Telah dilakukan ');

            return redirect('pembelian');
        } else {
            DB::beginTransaction();
            try {

                //Simpan ke table pembelian
                $tambah_pembelian = new \App\Pembelian;
                $tambah_pembelian->no_beli = $request->no_faktur;
                $tambah_pembelian->tgl_beli = $request->tgl;
                $tambah_pembelian->no_faktur = $request->no_faktur;
                $tambah_pembelian->total_beli = $request->total;
                $tambah_pembelian->no_pesan = $request->no_pesan;
                $tambah_pembelian->save();
    
                //SIMPAN ke table jurnal bagian debet
                $tambah_jurnaldebet = new \App\Jurnal;
                $tambah_jurnaldebet->no_jurnal = $request->no_jurnal;
                $tambah_jurnaldebet->keterangan = 'Pembelian Barang ';
                $tambah_jurnaldebet->tgl_jurnal = $request->tgl;
                $tambah_jurnaldebet->no_akun = $request->pembelian;
                $tambah_jurnaldebet->debet = $request->total;
                $tambah_jurnaldebet->kredit = '0';
                $tambah_jurnaldebet->save();
    
                //SIMPAN ke table jurnal bagian kredit
                $tambah_jurnalkredit = new \App\Jurnal;
                $tambah_jurnalkredit->no_jurnal = $request->no_jurnal;
                $tambah_jurnalkredit->keterangan = 'Kas';
                $tambah_jurnalkredit->tgl_jurnal = $request->tgl;
                $tambah_jurnalkredit->no_akun = $request->akun;
                $tambah_jurnalkredit->debet = '0';
                $tambah_jurnalkredit->kredit = $request->total;
                $tambah_jurnalkredit->save();
    
                //SIMPAN DATA KE TABEL DETAIL PEMBELIAN
                $kdbrg = $request->kd_brg;
                $qtybeli = $request->qty_beli;
                $subbeli = $request->sub_beli;
                $nmbrg = $request->nm_brg;
    
                foreach ($kdbrg as $key => $no) {
                    $input['no_beli'] = $request->no_faktur;
                    $input['kd_brg'] = $kdbrg[$key];
                    $input['qty_beli'] = $qtybeli[$key];
                    $input['sub_beli'] = $subbeli[$key];
                    DetailPembelian::insert($input);
    
                    DetailJurnal::create([
                        'jurnal_id' => $tambah_jurnaldebet->id,
                        'no_jurnal' => $request->no_jurnal,
                        'kd_brg' => $kdbrg[$key],
                        'nm_brg' => $nmbrg[$key],
                        'qty' => $qtybeli[$key],
                        'subtotal' => $subbeli[$key]
                    ]);
                }
                DB::commit();
                Alert::success('Pesan ', 'Data berhasil disimpan');
            } catch(\Throwable $e) {
                DB::rollback();
                throw $e;
            }
            return redirect('/pembelian');
        }
    }

    public function reportPDF(Request $request)
    {
        $periode = $request->periode;
        $pesan = [];
        $suffixMessage = "";
        if ($periode == "All") {
            $pesan = DB::select('SELECT * FROM pemesanan where not exists (select * from pembelian where pemesanan.no_pesan=pembelian.no_pesan)');
            $suffixMessage = "Seluruh Periode";
        } else {
            $firstDate = $request->tglawal;
            $secondDate = $request->tglakhir;

            $start_date = Carbon::createFromFormat('Y-m-d', $firstDate);
            $end_date = Carbon::createFromFormat('Y-m-d', $secondDate);
            $days = $start_date->diffInDays($end_date)+1;

            if ($days < 7) {
                $suffixMessage = "Harian";
            } 
            if ($days >= 7 && $days <= 30) {
                $suffixMessage = "Mingguan";
            }
            if ($days > 30) {
                $suffixMessage = "Bulanan";
            }

            $pesan = DB::table('pembelian')
                ->join('pemesanan', 'pembelian.no_pesan', '=', 'pemesanan.no_pesan')
                ->whereBetween('tgl_beli', [$firstDate, $secondDate])
                ->orderby('tgl_beli','ASC')
                ->get();
        }
        // $details = array();
        for ($i=0; $i < count($pesan); $i++) { 
            $details[$i] = DB::table('tampil_pemesanan')->where('no_pesan', $pesan[$i]->no_pesan)->get()->toArray();
        }
        $pdf = PDF::loadView('laporan.print_pembelian', ['data' => $pesan, 'suffix_message' => $suffixMessage, 'details' => (array)$details]);
        return $pdf->stream();
    }

    public function delete(Request $request)
    {
        $no_pesan = $request->no_pesan;
        $pemesanan = \App\Pemesanan::where('no_pesan', $no_pesan)->first();
        if ($pemesanan) {
            $detailPesan = \App\DetailPesan::where('no_pesan', $no_pesan)->first();
            if ($detailPesan) {
                DB::table('detail_pesan')->where('no_pesan', $no_pesan)->delete();
            }
            DB::table('pemesanan')->where('no_pesan', $no_pesan)->delete();
        }
       return [
            'success' => true
       ];
    }
}
