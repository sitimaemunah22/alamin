<?php

namespace App\Http\Controllers;

use App\Models\donatur;
use App\Http\JenisPemasukan;
use Illuminate\Http\Request;
use App\Models\jenis_pemasukan;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class DonaturController extends Controller
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
        $data = donatur::all();
        return view('dashboard.donatur.index', compact('data'));
    }
    

    public function simpan(Request $request)
    {

        $id = $request->id;

        $data = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_telephone' => 'required',
            'upload' => 'file'
        ]);

        if ($data) {
            if ($request->input('id') !== null) {
                // TODO: Update Foto

                if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
                    $foto_file = $request->file('upload');
                    $foto_extension = $foto_file->getClientOriginalExtension();
                    $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_extension;
                    $foto_file->move(public_path('donatur'), $foto_nama);
    
                    $update_data = donatur::where('id', $id)->first();
                    File::delete(public_path('donatur') . '/' . $update_data->file);
    
                    $data['upload'] = $foto_nama;
                }


                // TODO: Update Donatur
                $donatur = donatur::query()->find($request->input('id'));
                $donatur->fill($data);
                $donatur->save();

                // return response()->json([
                //     'message' => 'Donatur berhasil diupdate!'
                // ], 200);

                return redirect()->to('/dashboard/donatur')->with('success', 'Donatur berhasil diupdate');
            }

            if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
                $foto_file = $request->file('upload');
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_file->getClientOriginalExtension();
                $foto_file->move(public_path('donatur'), $foto_nama);
                $data['upload'] = $foto_nama;
            }
            
            $dataInsert = Donatur::create($data);
            if ($dataInsert) {
                return redirect()->to('/dashboard/donatur')->with('success', 'Donatur berhasil ditambah');
            }
        }

        return redirect()->to('/dashboard/donatur')->with('error', 'Gagal tambah data');
    }

    public function edit(Request $request)
    {
        $id = $request->id;

        $data = [
            'donatur' => donatur::find($id),
        ];

        return view('dashboard.donatur.edit', $data);
    }


    public function tambah()
    {
        return view('dashboard.donatur.tambah');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'donatur' => ['required', 'max:40']
        ]);
    }
}
