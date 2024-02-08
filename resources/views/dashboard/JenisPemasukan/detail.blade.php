@extends('layouts.app')
@section('title', 'Pemasukan')
@section('content')

<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <!-- Your head content here -->
</head>
<body>
    <!-- Your body content here -->
    <!-- Your SVG and aside content -->

    <main>
        <div class="container pt-4">
            @yield('content')
        </div>
    </main>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="sidebars.js"></script>
</body>
</html>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card" style="margin-left: 200px; height: 550px; width:800px;">
                <div class="card-body">
                    @if(isset($jenis_pemasukan))
                    <form action="{{ route('simpan.jenispemasukan') }}" method="post">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <h3 class="text-center mb-4">Detail Jenis Pemasukan</h3>
                            <label for="">Jenis Pemasukan</label>
                            <input type="text" id="nama_pemasukan" name="nama_pemasukan" class="form-control"
                                placeholder="nama_pemasukan" value="{{ $jenis_pemasukan->nama_pemasukan }}" disabled>
                            <input type="text" id="id_jenis_pemasukan" name="id_jenis_pemasukan" class="form-control"
                                value="{{ $jenis_pemasukan->id_jenis_pemasukan }}" hidden>
                        </div>
                        <div class="form-group text-left">
                        <a href="{{ route('jenispemasukan.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                    </form>
                    @else
                    <div class="alert alert-danger" role="alert">
                        Jenis pemasukan tidak ditemukan.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
