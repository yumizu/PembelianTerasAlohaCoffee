<?php

namespace App\Http\Controllers;
use Alert;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB as FacadesDB;
use Spatie\Permission\Models\Role;
use Iluminate\Support\Facades\DB;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user= User::All();
        return view('admin.user',['user'=>$user]);
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
        $save_user= new \App\User;
        $save_user->name=$request->get('username');
        $save_user->email=$request->get('email');
        $save_user->password= bcrypt('password');
        if ($request->get('roles')=='ADMIN'){
        $save_user->assignRole('admin');}
        else
        {
        $save_user->assignRole('user');}
        $save_user->save();
        Alert::success('Tersimpan','Data Berhasil disimpan');
        return redirect()->route('user.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.user',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name')->all();
        return view('admin.editUser',compact('user','roles'));
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
        $user = User::find($request->id);
        FacadesDB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->roles);
        // Change password if the user fill the password field
        if (isset($request->password)) {
            $user->password = bcrypt($request->password);
            $user->save();
        }
        Alert::success('Update', 'Data Berhasil di Update');
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapus = \App\User::findOrFail($id);
        $hapus->delete();
        $hapus->removeRole('admin','user');
        Alert::success('Terhapus','Data Berhasil dihapus');
        return redirect()->route('user.index');
    }
}
