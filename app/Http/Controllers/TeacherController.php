<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Facade;

class TeacherController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('teacher.index',compact('posts'));
    }
    public function cari(Request $request)
    {
        $keyword = $request->input('cari');

        // mengambil data dari table pegawai sesuai pencarian data
        $posts = Post::where('nama', 'like', "%" . $keyword . "%")->paginate(10);


        // mengirim data pegawai ke view index
        return view('teacher.index', compact('posts'));
    }
}
