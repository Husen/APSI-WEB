<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pegawai;
class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawais = Pegawai::all();
        $trash = Pegawai::onlyTrashed()->get();
        return view('pegawai', compact('pegawais','trash'));
            
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
        $pegawai = new Pegawai;
        $pegawai->id_pegawai = $request->get('id_pegawai');
        $pegawai->nama = $request->get('nama');
        $pegawai->jenis_kelamin = $request->get('jenis_kelamin');
        $pegawai->no_hp = $request->get('no_hp');
        $pegawai->jabatan = $request->get('jabatan');
        $pegawai->alamat = $request->get('alamat');
        $pegawai->email = $request->get('email');

        $pegawai->save();

        return redirect('pegawai')->with('added_success', 'Data Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pegawai = Pegawai::getPegawai($id);

        return response()->json($pegawai);
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
        $pegawai = Pegawai::where('id_pegawai', $request->get('id_pegawai'))
        ->update([
            'nama' => $request->get('nama'),
            'jenis_kelamin' => $request->get('jenis_kelamin'),
            'no_hp' => $request->get('no_hp'),
            'jabatan' => $request->get('jabatan'),
            'alamat' => $request->get('alamat'),
            'email' => $request->get('email'),

        ]);

        return redirect('pegawai')->with('updated_success', 'Data Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $pegawai = Pegawai::where('id_pegawai', $request->get('id_pegawai'))
        ->delete();

        return redirect('pegawai')->with('deleted_success', 'Data berhasil dihapus');
    }
    public function emptyAll(){
        Pegawai::onlyTrashed()
            ->forceDelete();
        return redirect('pegawai')->with('empty_success', 'Semua Data berhasil dihapus');
    }

    public function restoreAll(){
        Pegawai::onlyTrashed()
            ->restore();
         return redirect('pegawai')->with('restore_all_success', 'Semua Data berhasil dikembalikan');
    }
    
    public function restore(Request $request){
        Pegawai::onlyTrashed()
            ->where('id_pegawai', $request->get('id_pegawai'))
            ->restore();
        return redirect('pegawai')->with('force_delete_success', 'Data berhasil dikembalikan');
    }

    public function forceDelete(Request $request){
        Pegawai::onlyTrashed()
        ->where('id_pegawai', $request->get('id_pegawai'))
        ->forceDelete();
    return redirect('pegawai')->with('force_delete_success', 'Data berhasil dikembalikan');
    }
} 
