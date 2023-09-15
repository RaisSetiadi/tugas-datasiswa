<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Pdf;
use Barryvdh\DomPDF\Facade\PDF as FacadePdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class PostController extends Controller
{
    //
    
    public function index(): view
    {
        $posts = Post::paginate(10);
        return view('posts.index',compact('posts'));
    }
    public function create(): view
    {
        return view('posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request,[
            'nama' =>'required|min:10',
            'kelas'=> 'required|min:5',
            'jenis_kelamin'=>'required|min:5',
        ]);

    Post::create([
        'nama'     => $request->nama,
        'kelas'     => $request->kelas,
        'jenis_kelamin'   => $request->jenis_kelamin
    ]);

return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Disimpan!']);
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
    $post = Post::findOrFail($id);

    return view('posts.edit',compact('post'));
}
public function update(Request $request, $id): RedirectResponse
{
    $this->validate($request,[
        'nama' =>'required|min:10',
        'kelas'=> 'required|min:5',
        'jenis_kelamin'=>'required|min:5'

    ]);

    $post = Post::FindOrFail($id);

    $post->update([
        'nama'     => $request->nama,
        'kelas'     => $request->kelas,
        'jenis_kelamin'   => $request->jenis_kelamin
    ]);


return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Diubah!']);
}
    public function destroy($id): RedirectResponse
    {
        //get post by ID
        $post = Post::findOrFail($id);
        //delete post
        $post->delete();

        //redirect to index
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
    public function cetak()
    {
        $post = Post::all();

        $pdf = facadePdf::loadview('posts.cetak', ['Post' => $post]);
        return $pdf->download('Data_siswa.pdf');
    }

    public function cari(Request $request)
    {
        $keyword = $request->input('cari');

        // mengambil data dari table pegawai sesuai pencarian data
        $posts = Post::where('nama', 'like', "%" . $keyword . "%")->paginate(10);


        // mengirim data pegawai ke view index
        return view('posts.index', compact('posts'));
    }
}