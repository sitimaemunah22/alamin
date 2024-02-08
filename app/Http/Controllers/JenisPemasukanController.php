<?php

namespace App\Http\Controllers;

use App\Http\JenisPemasukan;
use App\Models\jenis_pemasukan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JenisPemasukanController extends Controller
{
    // public function index()
    // {
    //     $data = [
    //         'jenis_pemasukan' => JenisPemasukan::all()
    //     ];

    //     return view('jenispemasukan.index', $data);
    // }

    public function index()
{
    $jenis_pemasukan = jenis_pemasukan::all();
    return view('dashboard.JenisPemasukan.index', compact('jenis_pemasukan'));
}

public function tambah()
{
    return view('dashboard.JenisPemasukan.tambah');
}

public function edit(Request $request)
    {
        $id = $request->id;

        $data = [
            'jenis_pemasukan' => jenis_pemasukan::find($id)
        ];

        return view('dashboard.JenisPemasukan.edit', $data);
    }
    

    public function detail(Request $request)
    {
        $id = $request->id;

        $data = [
            'jenis_pemasukan' => jenis_pemasukan::find($id)
        ];

        return view('dashboard.JenisPemasukan.detail', $data);
    }

    // public function kembali(Request $request)
    // {
    //     $id = $request->id;

    //     $data = [
    //         'jenis_pemasukan' => jenis_pemasukan::find($id)
    //     ];

    //     return view('dashboard.JenisPemasukan.jenispemasukan', $data);
    // }
    

    public function simpan(Request $request)
    {
        $data = $request->validate([
            'nama_pemasukan' => ['required', 'max:40']
        ]);

        if ($data) {
            if ($request->input('id_jenis_pemasukan') !== null) {

                // TODO: Update Jenis Surat
                $JenisPemasukan = jenis_pemasukan::query()->find($request->input('id_jenis_pemasukan'));
                $JenisPemasukan->fill($data);
                $JenisPemasukan->save();

                // return response()->json([
                //     'message' => 'Jenis pemasukan berhasil diupdate!'
                // ], 200);

                return redirect()->to('/dashboard/jenispemasukan')->with('success', 'Jenis pemasukan berhasil diupdate');
            }

            $dataInsert = jenis_pemasukan::create($data);
            if ($dataInsert) {
                return redirect()->to('/dashboard/jenispemasukan')->with('success', 'Jenis pemasukan berhasil ditambah');
            }
        }

        return redirect()->to('/dashboard/jenispemasukan')->with('error', 'Gagal tambah data');
    }


    public function delete(int $id): JsonResponse
    {
        $JenisPemasukan = JenisPemasukan::query()->find($id)->delete();

        if ($JenisPemasukan):
            //Pesan Berhasil
            $pesan = [
                'success' => true,
                'pesan' => 'Data user berhasil dihapus'
            ];
        else:
            //Pesan Gagal
            $pesan = [
                'success' => false,
                'pesan' => 'Data gagal dihapus'
            ];
        endif;
        return response()->json($pesan);
    }
}
