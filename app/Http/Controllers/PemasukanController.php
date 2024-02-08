<?php

namespace App\Http\Controllers;

use App\Models\donatur;
use App\Models\pemasukan;
use Illuminate\Http\Request;
use App\Models\jenis_pemasukan;
use Illuminate\Support\Facades\File;
use App\Http\Requests\PemasukanCreateRequest;
use App\Http\Requests\PemasukanUpdateRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PemasukanController extends Controller
{
    // public function index(): View
    // {
    //     $data = [
    //         'pemasukan_with_relationships' => Pemasukan::with('jenis', 'user')->orderByDesc('tanggal_pemasukan')->get(),
    //         'all_pemasukan' => Pemasukan::all()
    //     ];

    //     return view('dashboard.pemasukan.index', $data);
    // }
    public function index()
    {
        $data = pemasukan::all();
        return view('dashboard.pemasukan.index', compact('data'));
    }
    public function tambah()
    {
        $data = [
            'jenis_pemasukan' => jenis_pemasukan::all(),
            'donatur' => donatur::all()
        ];

        return view('dashboard.pemasukan.tambah', $data);
    }

    public function simpan(Request $request)
    {
        
        $id = $request->id;

        $data = $request->validate([ 
            'id_jenis_pemasukan' => 'required',
            'id_donatur' => 'required', 
            'jumlah_pemsukan' => 'required', 
            'tanggal_pemasukan' => 'required',
            'upload' => 'file',
        ]);
        
        if ($data) {
            if ($request->input('id') !== null) {
                // TODO: Update Foto

                if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
                    $foto_file = $request->file('upload');
                    $foto_extension = $foto_file->getClientOriginalExtension();
                    $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_extension;
                    $foto_file->move(public_path('pemasukan'), $foto_nama);
    
                    $update_data = pemasukan::where('id', $id)->first();
                    File::delete(public_path('pemasukan') . '/' . $update_data->file);
    
                    $data['upload'] = $foto_nama;
                }

                // TODO: Update Pemasukan
                $pemasukan = pemasukan::query()->find($request->input('id'));
                $pemasukan->fill($data);
                $pemasukan->save();

                // return response()->json([
                //     'message' => 'Pemasukan berhasil diupdate!'
                // ], 200);

                return redirect()->to('/dashboard/pemasukan')->with('success', 'Pemasukan berhasil diupdate');
            }

            if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
                $foto_file = $request->file('upload');
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_file->getClientOriginalExtension();
                $foto_file->move(public_path('pemasukan'), $foto_nama);
                $data['upload'] = $foto_nama;
            }

            $dataInsert = pemasukan::create($data);
            if ($dataInsert) {
                return redirect()->to('/dashboard/pemasukan')->with('success', 'Pemasukan berhasil ditambah');
            }
        }

        return redirect()->to('/dashboard/pemasukan')->with('error', 'Gagal tambah data');
    }

    public function edit(Request $request)
    {
        $id = $request->id;

        $data = [
            'pemasukan' => pemasukan::with('jenis_pemasukan')->find($id),
            'jenis_pemasukan' => jenis_pemasukan::all(),
            'donatur' => donatur::all()
        ];

        // dd($data);
        return view('dashboard.Pemasukan.edit', $data);
    }

    public function detail()
    {
        $data = pemasukan::all();
        return view('dashboard.pemasukan.detail');
    }
}

    

//     public function download(Request $request)
//     {
//         return Storage::download("public/$request->path");
//     }

//     public function update(PemasukanUpdateRequest $request)
//     {
//         $data = $request->validated();
//         $pemasukan = Pemasukan::query()->find($request->id);

//         if ($path = $request->file('file')) {
//             // Delete old file
//             if ($pemasukan->file) {
//                 Storage::delete("public/$pemasukan->file");
//             }

//             // Store new file
//             $path = $path->storePublicly('', 'public');
//             $data['file'] = $path;
//         }

//         $pemasukan->fill($data)->save();

//         return [
//             'message' => 'Berhasil update surat!'
//         ];
//     }

//     public function delete(int $id)
//     {
//         $pemasukan = Pemasukan::query()->find($id);

//         if (!$pemasukan) {
//             throw new HttpResponseException(response()->json([
//                 'message' => 'Not found'
//             ])->setStatusCode(404));
//         }

//         // Deleting file
//         Storage::delete("public/$pemasukan->file");
//         // Deleting surat
//         $pemasukan->delete();

//         return response()->json([
//             'success' => true,
//             'message' => 'Berhasil menghapus data pemasukan'
//         ], 200);
//     }
// }