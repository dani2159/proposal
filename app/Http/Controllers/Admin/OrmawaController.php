<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ormawa;
use Illuminate\Http\Request;

class OrmawaController extends Controller
{
    public function index()
    {
        $data['list'] = Ormawa::where(['is_deleted' => 0])->get();
        return view('Admin.ormawa.index', $data);
    }

    public function insert(Request $request)
    {
        $insert['nama'] = $request->nama;
        $insert['ketua'] = $request->ketua;
        $insert['keterangan'] = $request->keterangan;

        if (Ormawa::create($insert)) {
            $result['status'] = true;
            $result['message'] = 'Data ormawa berhasil disimpan.';
        } else {
            $result['status'] = false;
            $result['message'] = 'Data ormawa gagal disimpan.';
        }
        
        return $result;
    }

    public function delete(Request $request)
    {
        $getData = Ormawa::where(['id' => $request->id])->first();

        if ($getData) {
            $getData->is_deleted = 1;

            if ($getData->save()) {
                $result['status'] = true;
                $result['message'] = 'Data ormawa berhasil dihapus.';
            } else {
                $result['status'] = false;
                $result['message'] = 'Data ormawa gagal dihapus.';
            }
        } else {
            $result['status'] = false;
            $result['message'] = 'Data ormawa tidak ditemukan.';
        }
        
        return $result;
    }

    public function update(Request $request)
    {
        $getData = Ormawa::where(['id' => $request->id])->first();

        if ($getData) {
            $getData->nama = $request->nama;
            $getData->ketua = $request->ketua;
            $getData->keterangan = $request->keterangan;

            if ($getData->save()) {
                $result['status'] = true;
                $result['message'] = 'Data ormawa berhasil diubah.';
            } else {
                $result['status'] = false;
                $result['message'] = 'Data ormawa gagal diubah.';
            }
        } else {
            $result['status'] = false;
            $result['message'] = 'Data ormawa tidak ditemukan.';
        }
        
        return $result;
    }
}
