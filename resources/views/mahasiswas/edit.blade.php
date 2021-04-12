@extends('mahasiswas.layout')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center align-items-center">
        <div class="card" style="width: 24rem;">
            <div class="card-header">
                Edit Mahasiswa
            </div>
            <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        <form method="post" action="{{ route('mahasiswa.update', $Mahasiswa->nim) }}" id="myForm">
        @csrf
        @method('PUT')
            <div class="form-group">
                <label for="nim">Nim</label>
                <input type="text" name="nim" class="form-control" id="nim" value="{{ $Mahasiswa->nim }}" ariadescribedby="Nim" >
            </div>
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" class="form-control" id="nama" value="{{ $Mahasiswa->nama }}" ariadescribedby="nama" >
            </div>
            <div class="form-group">
                <label for="kelas">Kelas</label>
                <select name="kelas" class="form-control">
                    @foreach ($kelas as $kls)
                        <option value="{{$kls->id}}" {{$Mahasiswa->kelas_id == $kls->id ? 'selected' : ''}}>{{$kls->nama_kelas}}</option>     
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="jurusan">Jurusan</label>
                <input type="jurusan" name="jurusan" class="form-control" id="jurusan" value="{{ $Mahasiswa->jurusan }}" ariadescribedby="jurusan" >
            </div>
            <div class="form-group">
                <label for="no_hp">no_hp</label>
                <input type="no_hp" name="no_hp" class="form-control" id="no_hp" value="{{ $Mahasiswa->no_hp }}" ariadescribedby="no_hp" >
            </div>
            <div class="form-group">
            <label for="email">email</label>
            <input type="email" name="email" class="form-control" id="email" aria-describedby="email" >
        </div>
        <div class="form-group">
            <label for="tanggal_lahir">tanggal_lahir</label>
            <input type="tanggal_lahir" name="tanggal_lahir" class="form-control" id="tanggal_lahir" aria-describedby="tanggal_lahir" >
        </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    </div>
    </div>
</div>
@endsection