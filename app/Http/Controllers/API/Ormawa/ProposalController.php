<?php

namespace App\Http\Controllers\API\Ormawa;

use App\Helpers\ApiFormatter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ormawa;
use Illuminate\Support\Facades\DB;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Support\Str;
class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getUser = User::where(['id' => Auth()->user()->id])->first();
        $data['menunggu'] = Proposal::where(['is_deleted' => 0, 'is_active' => 1, 'status' => 0, 'id_ormawa' => $getUser->id_ormawa])->count();
        $data['ditolak'] = Proposal::where(['is_deleted' => 0, 'is_active' => 1, 'status' => 2, 'id_ormawa' => $getUser->id_ormawa])->count();
        $data['disetujui'] = Proposal::where(['is_deleted' => 0, 'is_active' => 1, 'status' => 1, 'id_ormawa' => $getUser->id_ormawa])->count();
        return view('Admin.home', $data);
    }

    public function proposal()
    {
        $getUserLogin = User::where(['id' => Auth()->user()->id])->first();
        $data = Proposal::where(['id_ormawa' => $getUserLogin->id_ormawa, 'is_active' => 1])->with('ormawa')->get();
        return view ('Ormawa.proposal', compact('data'));
    }

    public function lpj(Request $request)
    {
        $getData = Proposal::where(['id' => $request->id])->first();

        if ($getData) {
            if($request->hasfile('userfile')) {
                $file = $request->file('userfile');
                $system_name_file = time().".".$file->getClientOriginalExtension();
    
                $path = base_path().'/public/data_lpj/';
                $file->move($path, $system_name_file);

                $getData->lampiran_lpj = $system_name_file;
    
                if ($getData->save()) {
                    $result['status'] = true;
                    $result['message'] = 'LPJ berhasil dikirim.';
                } else {
                    $result['status'] = false;
                    $result['message'] = 'LPJ gagal dikirim.';
                }
            } else {
                $result['status'] = false;
                $result['message'] = 'Lampiran LPJ wajib dikirim.';
            }
        } else {
            $result['status'] = false;
            $result['message'] = 'Data proposal tidak ditemukan.';
        }
        

        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ormawa = Ormawa::all();
        //dd($ormawa);
        return view('Ormawa.create' , compact('ormawa'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasfile('userfile')) {
            $file = $request->file('userfile');
            $system_name_file = time().".".$file->getClientOriginalExtension();

            $path = base_path().'/public/data_proposal/';
            $file->move($path, $system_name_file);

            $getUser = User::where(['id' => Auth()->user()->id])->first();

            $insert['id_ormawa'] = $getUser->id_ormawa;
            $insert['nama_kegiatan'] = $request->nama_kegiatan;
            $insert['jenis_kegiatan'] = $request->jenis_kegiatan;
            $insert['tema_kegiatan'] = $request->tema_kegiatan;
            $insert['tanggal_kegiatan'] = $request->tanggal_kegiatan;
            $insert['total_dana'] = $request->total_dana;
            $insert['lampiran'] = $system_name_file;

            if (Proposal::create($insert)) {
                $result['status'] = true;
                $result['message'] = 'Pengajuan proposal berhasil dikirim.';
            } else {
                $result['status'] = false;
                $result['message'] = 'Pengajuan proposal gagal dilakukan.';
            }
        } else {
            $result['status'] = false;
            $result['message'] = 'Lampiran wajib dikirim.';
        }

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$data = Proposal::where('id','=', $id)->get();
        $data = DB::table('pengajuan_ormawa')->where('id', $id)->first();
        return view('proposal.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['item'] = Proposal::where(['id' => $id])->first();
        return view('Ormawa.edit', $data);
    }

    public function pengajuanUlang($id)
    {
        $data['item'] = Proposal::where(['id' => $id])->first();
        return view('Ormawa.ajukan-ulang', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $getData = Proposal::where(['id' => $request->id])->first();

        if ($getData) {
            if($request->hasfile('userfile')) {
                $file = $request->file('userfile');
                $system_name_file = time().".".$file->getClientOriginalExtension();
    
                $path = base_path().'/public/data_proposal/';
                $file->move($path, $system_name_file);
                $getData->lampiran = $system_name_file;
            }

            $getUser = User::where(['id' => Auth()->user()->id])->first();

            $getData->id_ormawa = $getUser->id_ormawa;
            $getData->nama_kegiatan = $request->nama_kegiatan;
            $getData->jenis_kegiatan = $request->jenis_kegiatan;
            $getData->tema_kegiatan = $request->tema_kegiatan;
            $getData->tanggal_kegiatan = $request->tanggal_kegiatan;
            $getData->total_dana = $request->total_dana;

            if ($getData->save()) {
                $result['status'] = true;
                $result['message'] = 'Proposal berhasil diubah.';
            } else {
                $result['status'] = false;
                $result['message'] = 'Proposal gagal diubah.';
            }
        } else {
            $result['status'] = false;
            $result['message'] = 'Proposal tidak ditemukan.';
        }
        
        return $result;
    }
    
    public function updatePengajuanUlang(Request $request)
    {
        $getData = Proposal::where(['id' => $request->id])->first();

        if ($getData) {
            $getUser = User::where(['id' => Auth()->user()->id])->first();
            $getData->is_active = 0;
            $getData->save();
            if ($getData->id_parent) {
                /* id parent sudah ada, berarti sudah pernah di tolak sebelumnya */
                $insert['lampiran'] = $getData->lampiran;
                if($request->hasfile('userfile')) {
                    $file = $request->file('userfile');
                    $system_name_file = time().".".$file->getClientOriginalExtension();
        
                    $path = base_path().'/public/data_proposal/';
                    $file->move($path, $system_name_file);
                    $insert['lampiran'] = $system_name_file;
                }
                $insert['id_ormawa'] = $getUser->id_ormawa;
                $insert['nama_kegiatan'] = $request->nama_kegiatan;
                $insert['jenis_kegiatan'] = $request->jenis_kegiatan;
                $insert['tema_kegiatan'] = $request->tema_kegiatan;
                $insert['tanggal_kegiatan'] = $request->tanggal_kegiatan;
                $insert['total_dana'] = $request->total_dana;
                $insert['id_parent'] = $getData->id_parent;

                if (Proposal::create($insert)) {
                    $result['status'] = true;
                    $result['message'] = 'Pengajuan ulang proposal berhasil.';
                } else {
                    $result['status'] = false;
                    $result['message'] = 'Pengajuan ulang proposal gagal.';
                }
            } else {
                /* id parent null, berarti proposal pertama kali ditolak */
                $insert['lampiran'] = $getData->lampiran;
                if($request->hasfile('userfile')) {
                    $file = $request->file('userfile');
                    $system_name_file = time().".".$file->getClientOriginalExtension();
        
                    $path = base_path().'/public/data_proposal/';
                    $file->move($path, $system_name_file);
                    $insert['lampiran'] = $system_name_file;
                }
                $insert['id_ormawa'] = $getUser->id_ormawa;
                $insert['nama_kegiatan'] = $request->nama_kegiatan;
                $insert['jenis_kegiatan'] = $request->jenis_kegiatan;
                $insert['tema_kegiatan'] = $request->tema_kegiatan;
                $insert['tanggal_kegiatan'] = $request->tanggal_kegiatan;
                $insert['total_dana'] = $request->total_dana;
                $insert['id_parent'] = $getData->id;
                
                if (Proposal::create($insert)) {
                    $result['status'] = true;
                    $result['message'] = 'Pengajuan ulang proposal berhasil.';
                } else {
                    $result['status'] = false;
                    $result['message'] = 'Pengajuan ulang proposal gagal.';
                }
            }
        } else {
            $result['status'] = false;
            $result['message'] = 'Proposal tidak ditemukan.';
        }
        
        return $result;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $data = Proposal::findOrFail($id);
        //$data = $data->delete();
        $data = DB::table('pengajuan_ormawa')->where('id', '=' , $id);
        $file_path = public_path().'/data_proposal/'.$data->first()->lampiran;
        unlink($file_path);
        $data->delete();
        return redirect()->route('list-pengajuan-ormawa')->with('toast_success', 'Data Berhasil Dihapus');
            
     
    }
}
