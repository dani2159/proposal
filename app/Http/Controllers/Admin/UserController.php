<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ormawa;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $data['list'] = User::where(['is_deleted' => 0])->get();
        $data['ormawa'] = Ormawa::where(['is_deleted' => 0])->get();
        return view('Admin.users.index', $data);
    }

    public function insert(Request $request)
    {
        $checkUsername = User::where(['username' => $request->username, 'is_deleted' => 0])->first();

        if (!$checkUsername) {
            $insert['nama'] = $request->nama;
            $insert['level'] = $request->level;
            $insert['username'] = $request->username;
            $insert['password'] = bcrypt($request->password);
            $insert['id_ormawa'] = $request->id_ormawa;
    
            if (User::create($insert)) {
                $result['status'] = true;
                $result['message'] = 'Data user berhasil disimpan.';
            } else {
                $result['status'] = false;
                $result['message'] = 'Data user gagal disimpan.';
            }
        } else {
            $result['status'] = false;
            $result['message'] = 'Username telah digunakan.';
        }
        
        return $result;
    }

    public function delete(Request $request)
    {
        $getData = User::where(['id' => $request->id])->first();

        if ($getData) {
            $getData->is_deleted = 1;

            if ($getData->save()) {
                $result['status'] = true;
                $result['message'] = 'Data user berhasil dihapus.';
            } else {
                $result['status'] = false;
                $result['message'] = 'Data user gagal dihapus.';
            }
        } else {
            $result['status'] = false;
            $result['message'] = 'Data user tidak ditemukan.';
        }
        
        return $result;
    }

    public function update(Request $request)
    {
        $getData = User::where(['id' => $request->id])->first();

        if ($getData) {
            if ($getData->username != $request->username) {
                $checkUsername = User::where(['username' => $request->username, 'is_deleted' => 0])->first();

                if ($checkUsername) {
                    $result['status'] = false;
                    $result['message'] = 'Username telah digunakan.';

                    return $result;
                }
            }
            $getData->nama = $request->nama;
            $getData->level = $request->level;
            $getData->username = $request->username;
            if ($getData->password) {
                $getData->password = bcrypt($request->password);
            }
            $getData->id_ormawa = $request->id_ormawa;

            if ($getData->save()) {
                $result['status'] = true;
                $result['message'] = 'Data user berhasil diubah.';
            } else {
                $result['status'] = false;
                $result['message'] = 'Data user gagal diubah.';
            }
        } else {
            $result['status'] = false;
            $result['message'] = 'Data user tidak ditemukan.';
        }
        
        return $result;
    }
}
