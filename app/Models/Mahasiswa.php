<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Mahasiswa as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model; //model Eloquent

class Mahasiswa extends Model //definisi model
{
    protected $table="mahasiswas"; // Eloquent akan membuat model mahasiswa menyimpan record di table mahasiswas
    public $timestamps=false;
    protected $primaryKey = 'nim'; // Memanggil isi DB dengan Primarykey
    
    protected $fillable = [
        'nim',
        'nama',
        'kelas',
        'jurusan',
        'no_hp',
        'email',
        'tanggal_lahir',
    ];
    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }
    public function matakuliah(){
        return $this->belongsToMany(MataKuliah::class, 'mahasiswa_matakuliah', 'mahasiswa_id', 'matakuliah_id')->withPivot('nilai');
    }
};
