<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Kelas;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $search = request()->query('search');
        // if($search){
        //     // mencari mahasiswa
        //     $posts = Mahasiswa::where('nama', 'LIKE', "%{$search}%")->paginate(3);
        // } else {
        //     // mendapatkan list mahasiswa
        //     $posts = Mahasiswa::orderBy('nim','desc')->paginate(5); 
        // }
        // // $mahasiswas = Mahasiswa::all(); // Mengambil semua isi tabel
        // // $posts = Mahasiswa::orderBy('nim', 'desc')->paginate(5);
        // return view('mahasiswas.index', compact('posts'));
        // with('i',(request()->input('page', 1) - 1) * 5);
        $posts = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('nim', 'desc')->paginate(5);
        return view ('mahasiswas.index',['mahasiswa' => $posts,'paginate'=>$paginate]);
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
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswas.create', ['kelas' => $kelas]);
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
            'kelas_id' => 'required',
            'jurusan' => 'required',
            'no_hp' => 'required',
            'email' => 'required',
            'tanggal_lahir' => 'required',
        ]);
        // //fungsi eloquent untuk menambahkan data
        // Mahasiswa::create($request->all());

        // //jika data berhasil ditambahkan, akan kembali ke halaman utama
        // $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        // return view('mahasiswas.create', ['kelas' => $kelas]);
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('nim');
        $mahasiswa->nama = $request->get('nama');
        $mahasiswa->jurusan = $request->get('jurusan');
        $mahasiswa->no_hp = $request->get('no_hp');
        $mahasiswa->email = $request->get('email');
        $mahasiswa->tanggal_lahir = $request->get('tanggal_lahir');

        $kelas = new Kelas;
        $kelas->id = $request->get('kelas_id');

        //fungsi eloquent untuk menambah data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
            
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
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
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        return view('mahasiswas.detail', ['Mahasiswa' => $Mahasiswa]);
    }
    public function showKhs($nim) {
        $mahasiswa = Mahasiswa::with('kelas', 'matakuliah')->where('nim', $nim)->first();
        return view('mahasiswas.detailKhs', compact('mahasiswa'));
        // dd($mahasiswa);
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
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $kelas = Kelas::all(); //menampilkan data dari tabel kelas
        return view('mahasiswas.edit', compact('Mahasiswa', 'kelas'));
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
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'no_hp' => 'required',
            'email' => 'required',
            'tanggal_lahir' => 'required' 
        ]);

        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $mahasiswa->nim = $request->get('nim');
        $mahasiswa->nama = $request->get('nama');
        $mahasiswa->jurusan = $request->get('jurusan');
        $mahasiswa->no_hp = $request->get('no_hp');
        $mahasiswa->email = $request->get('email');
        $mahasiswa->tanggal_lahir = $request->get('tanggal_lahir');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('kelas');
        //fungsi eloquent untuk mengupdate data inputan kita
        // Mahasiswa::find($nim)->update($request->all());

        //fungsi eloquent untuk mengupdate data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
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
        return redirect()->route('mahasiswa.index')
            -> with('success', 'Mahasiswa Berhasil Dihapus');
    }
}
