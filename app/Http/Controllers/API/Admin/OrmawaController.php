<?php

namespace App\Http\Controllers\API\Admin;

use App\Helpers\ApiFormatter;

use App\Http\Controllers\Controller;
use App\Models\Ormawa;
use Illuminate\Http\Request;

class OrmawaController extends Controller
{
    public function index()
    {
        try {

         
            $data['list'] = Ormawa::where(['is_deleted' => 0])->get();
            if($data){
                return ApiFormatter::createApi(200, 'Succes', $data);
            } else {
                return ApiFormatter::createApi(400, 'Failed');

            }
        } catch(Exception $error) {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

    public function insert(Request $request)
    {
        try{
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
            
            if($result){
                return ApiFormatter::createApi(200, $result['message'], $result);
            } else {
                return ApiFormatter::createApi(400,$result['message']);

            }
        } catch(Exception $error) {
            return ApiFormatter::createApi(400, $result['message']);
        }
    }

    public function delete(Request $request)
    {
        try{
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
            
            if($result){
                return ApiFormatter::createApi(200, $result['message'], $result);
            } else {
                return ApiFormatter::createApi(400,$result['message']);

            }
        } catch(Exception $error) {
            return ApiFormatter::createApi(400, $result['message']);
        }
    }

    public function update(Request $request)
    {
        try{
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
            
            if($result){
                return ApiFormatter::createApi(200, $result['message'], $result);
            } else {
                return ApiFormatter::createApi(400,$result['message']);

            }
        } catch(Exception $error) {
            return ApiFormatter::createApi(400, $result['message']);
        }
    }
}
