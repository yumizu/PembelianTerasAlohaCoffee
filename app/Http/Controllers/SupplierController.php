<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;
use App\Supplier;
use Spatie\Permission\Models\Role;
use Iluminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier=\App\Supplier::All();
        return view('admin.supplier',['supplier'=>$supplier]);
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
        $tambah_supplier=new \App\Supplier;
        $tambah_supplier->kd_supp = $request->addkdsupp;
        $tambah_supplier->nm_supp = $request->addnmsupp;
        $tambah_supplier->alamat = $request->addalamat;
        $tambah_supplier->telepon = $request->addtelepon;
        $tambah_supplier->save();
        Alert::success('Pesan','Data Berhasil disimpan');
        return redirect()->route('supplier.index');
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
        $supplier_edit = \App\Supplier::findOrFail($id);
        return view('admin.editSupplier',['supplier'=>$supplier_edit]);
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
        $update_supplier = \App\Supplier::findOrFail($id);
        $update_supplier->kd_supp=$request->get('addkdsupp');
        $update_supplier->nm_supp=$request->get('addnmsupp');
        $update_supplier->alamat=$request->get('addalamat');
        $update_supplier->telepon=$request->get('addtelepon');
        $update_supplier->save();
        Alert::success('Update', 'Data Berhasil diupdate');
        return redirect()->route('supplier.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier=\App\Supplier::findOrFail($id);
        $supplier->delete();
        Alert::success('Pesan','Data berhasil dihapus');
        return redirect()->route('supplier.index');
    }
}
