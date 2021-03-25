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
                <label for="name">Nama</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $Mahasiswa->name }}" ariadescribedby="name" >
            </div>
            <div class="form-group">
                <label for="kelas">Kelas</label>
                <input type="kelas" name="kelas" class="form-control" id="kelas" value="{{ $Mahasiswa->kelas }}" ariadescribedby="kelas" >
            </div>
            <div class="form-group">
                <label for="jurusan">Jurusan</label>
                <input type="jurusan" name="jurusan" class="form-control" id="jurusan" value="{{ $Mahasiswa->jurusan }}" ariadescribedby="jurusan" >
            </div>
            <div class="form-group">
                <label for="no_hp">no_hp</label>
                <input type="no_hp" name="no_hp" class="form-control" id="no_hp" value="{{ $Mahasiswa->no_hp }}" ariadescribedby="no_hp" >
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    </div>
    </div>
</div>
@endsection