<?php

namespace App\Http\Controllers;

use App\Models\Walikelas;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class WalikelasController extends Controller
{
    //
    public function index(): view
    {
        $posts = Walikelas::latest()->paginate(5);
        return view('guru.index',compact('posts'));
    }
    public function create(): view
    {
        return view('guru.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request,[
            'nama' =>'required|min:10',
            'kelas'=> 'required|min:5',
            'jenis_kelamin'=>'required|min:5',
        ]);

    Walikelas::create([
        'nama'     => $request->nama,
        'kelas'     => $request->kelas,
        'jenis_kelamin'   => $request->jenis_kelamin
    ]);

return redirect()->route('guru.index')->with(['success' => 'Data Berhasil Disimpan!']);
}
/**
 * edit
 * 
 * 
 * @param mixed $id
 * @returm view
 */
public function edit(string $id):view
{
    $post = Walikelas::findOrFail($id);

    return view('guru.edit',compact('post'));
}
public function update(Request $request, $id): RedirectResponse
{
    $this->validate($request,[
        'nama' =>'required|min:10',
        'kelas'=> 'required|min:5',
        'jenis_kelamin'=>'required|min:5'

    ]);

    $post = Walikelas::FindOrFail($id);

    $post->update([
        'nama'     => $request->nama,
        'kelas'     => $request->kelas,
        'jenis_kelamin'   => $request->jenis_kelamin
    ]);


return redirect()->route('guru.index')->with(['success' => 'Data Berhasil Diubah!']);
}
public function destroy($id): RedirectResponse
{
    //get post by ID
    $walikelas = Walikelas::findOrFail($id);
    //delete post
    $walikelas->delete();

    //redirect to index
    return redirect()->route('guru.index')->with(['success' => 'Data Berhasil Dihapus!']);
}

public function cari(Request $request)
{
    $keyword = $request->input('cari');

    // mengambil data dari table pegawai sesuai pencarian data
    $posts = Walikelas::where('nama', 'like', "%" . $keyword . "%")->paginate(10);


    // mengirim data pegawai ke view index
    return view('guru.index', compact('posts'));
}
}