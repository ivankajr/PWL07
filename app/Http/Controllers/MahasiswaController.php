<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request()->query('search');
        if($search){
            // mencari mahasiswa
            $posts = Mahasiswa::where('nama', 'LIKE', "%{$search}%")->paginate(3);
        } else {
            // mendapatkan list mahasiswa
            $posts = Mahasiswa::orderBy('nim','desc')->paginate(5); 
        }
        // $mahasiswas = Mahasiswa::all(); // Mengambil semua isi tabel
        // $posts = Mahasiswa::orderBy('nim', 'desc')->paginate(5);
        return view('mahasiswas.index', compact('posts'));
        with('i',(request()->input('page', 1) - 1) * 5);
    }

    // public function cari(Request $request){
    //     // Menangkap pencarian 
    //     $cari = $request -> cari;

    //     // Mengambil data dari table mahasiswa sesuai pencarian data
    //     $mahasiswas = DB::table('mahasiswa')
    //     ->where('nama','like',"%".$cari."%")
    //     ->paginate();
        
    //     // Mengirim data mahasiswa ke view index
    //     return view('find',['mahasiswas' => $mahasiswa]);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mahasiswas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validasi data
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'no_hp' => 'required',
            'email' => 'required',
            'tanggal_lahir' => 'required',
        ]);
        //fungsi eloquent untuk menambahkan data
        Mahasiswa::create($request->all());

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nim)
    {
        //menampilkan data dengan menemukan/berdasarkan nim mahasiswa
        $Mahasiswa = Mahasiswa::find($nim);
        return view('mahasiswas.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nim)
    {
        //menampilkan detail data dengan menemukan 
        //berdasarkan nim mahasiswa untuk di edit
        $Mahasiswa = Mahasiswa::find($nim);
        return view('mahasiswas.edit', compact('Mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nim)
    {
        //melakukan validasi data
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'no_hp' => 'required',
            'email' => 'required',
            'tanggal_lahir' => 'required',
        ]);
        //fungsi eloquent untuk mengupdate data inputan kita
        Mahasiswa::find($nim)->update($request->all());
        //jika data berhasil di update, akan kembali ke halaman uutama
            return redirect()->route('mahasiswas.index')
                ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($nim)->delete();
        return redirect()->route('mahasiswas.index')
            -> with('success', 'Mahasiswa Berhasil Dihapus');
    }
}
