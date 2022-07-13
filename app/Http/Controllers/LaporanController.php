<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;
use Jurnal;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jurnalModel = new \App\Jurnal;
        $no_jurnal = $jurnalModel->pluck('no_jurnal')->unique()->all();
        return view('laporan.laporan', compact('no_jurnal'));
    }

    public function detail($no_jurnal)
    {
        $jurnalModel = new \App\Jurnal;
        $no_jurnal = str_replace('_', '/', $no_jurnal);
        $jurnal = $jurnalModel->where('no_jurnal', $no_jurnal)->get();
        return view('laporan.laporan_detail', compact('jurnal'));
    }

    public function detailBarang($jurnal_id)
    {
        $jurnalDetailModel = new \App\DetailJurnal();
        $details = $jurnalDetailModel->where('jurnal_id', $jurnal_id)->get();
        return view('laporan.laporan_detail_barang', compact('details'));
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
    public function show(Request $request)
    {
        $periode=$request->get('periode');
                if($periode == 'All')
                    {
                    $bb = \App\Laporan::All();
                    $akun=\App\Akun::All();
                    $pdf = PDF::loadview('laporan.cetak',['laporan'=>$bb,'akun' => $akun])->setPaper('A4','landscape');
                    return $pdf->stream();
                }elseif($periode == 'periode'){
                    $tglawal=$request->get('tglawal');
                    $tglakhir=$request->get('tglakhir');
                    $akun=\App\Akun::All();
                    $bb=DB::table('jurnal')
                            ->whereBetween('tgl_jurnal', [$tglawal,$tglakhir])
                            ->orderby('tgl_jurnal','ASC')
                            ->get();
                    $pdf = PDF::loadview('laporan.cetak',['laporan'=>$bb,'akun' => $akun])->setPaper('A4','landscape');
                    return $pdf->stream();
                }
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
