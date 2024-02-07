<?php

namespace App\Http\Controllers;

use App\Http\JenisPengeluaran;
use App\Models\jenis_pemasukan;
use App\Models\jenis_pengeluaran;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JenisPengeluaranController extends Controller
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
    $jenis_pengeluaran = jenis_pengeluaran::all();
    return view('dashboard.JenisPengeluaran.index', compact('jenis_pengeluaran'));
}

public function tambah()
{
    return view('dashboard.JenisPengeluaran.tambah');
}

public function edit(Request $request)
    {
        $id = $request->id;

        $data = [
            'jenis_pengeluaran' => jenis_pengeluaran::find($id)
        ];

        return view('dashboard.JenisPengeluaran.edit', $data);
    }
    

    public function simpan(Request $request)
    {
        $data = $request->validate([
            'nama_pengeluaran' => ['required', 'max:40']
        ]);

        if ($data) {
            if ($request->input('id_jenis_pengeluaran') !== null) {

                // TODO: Update Jenis Surat
                $JenisPengeluaran = jenis_pengeluaran::query()->find($request->input('id_jenis_pengeluaran'));
                $JenisPengeluaran->fill($data);
                $JenisPengeluaran->save();

                // return response()->json([
                //     'message' => 'Jenis pengeluaran berhasil diupdate!'
                // ], 200);

                return redirect()->to('/dashboard/jenispengeluaran')->with('success', 'Jenis pengeluaran berhasil diupdate');
            }

            $dataInsert = jenis_pengeluaran::create($data);
            if ($dataInsert) {
                return redirect()->to('/dashboard/jenispengeluaran')->with('success', 'Jenis pengeluaran berhasil ditambah');
            }
        }

        return redirect()->to('/dashboard/jenispengeluaran')->with('error', 'Gagal tambah data');
    }


    public function delete(int $id): JsonResponse
    {
        $JenisPengeluaran = JenisPengeluaran::query()->find($id)->delete();

        if ($JenisPengeluaran):
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
