<?php

namespace App\Http\Controllers\API\Bem;

use App\Helpers\ApiFormatter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ormawa;
use Illuminate\Support\Facades\DB;
use App\Models\Proposal;
class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $var_nama = "SyehBiaggie";
        return view('Bem.home', compact('var_nama'));
    }

    public function proposal()
    {
        $data = Proposal::where(['is_deleted' => 0, 'is_active' => 1])->get();
        return view ('Bem.proposal', compact('data'));
    }

    public function detail($id)
    {
        $item = Proposal::where(['id' => $id])->with('ormawa')->first();
        $history = array();
        if ($item->id_parent) {
            $getParent = Proposal::where(['id' => $item->id_parent])->first();
            $getParent2 = Proposal::where(['id_parent' => $item->id_parent])->where('is_active', '!=', 1)->get();
            if (count($getParent2)) {
                foreach ($getParent2 as $value) {
                    array_push($history, $value);
                }
            }
            array_push($history, $getParent);
        }
        $item->parent = $history;

        $data['item'] = $item;

        return view('Bem.detail-proposal', $data);
    }

    public function approve(Request $request)
    {
        $getData = Proposal::where(['id' => $request->id])->first();

        if ($getData) {
            $getData->status = 1;

            if ($getData->save()) {
                $result['status'] = true;
                $result['message'] = 'Pengajuan berhasil diterima';
            } else {
                $result['status'] = false;
                $result['message'] = 'Pengajuan gagal diproses';
            }
        } else {
            $result['status'] = false;
            $result['message'] = 'Data pengajuan tidak ditemukan';
        }

        return $result;        
    }

    public function reject(Request $request)
    {
        $getData = Proposal::where(['id' => $request->id])->first();

        if ($getData) {
            $getData->status = 2;
            $getData->note_reject = $request->note;

            if ($getData->save()) {
                $result['status'] = true;
                $result['message'] = 'Penolakan pengajuan berhasil dilakukan.';
            } else {
                $result['status'] = false;
                $result['message'] = 'Penolakan pengajuan gagal dilakukan.';
            }
        } else {
            $result['status'] = false;
            $result['message'] = 'Data pengajuan tidak ditemukan';
        }

        return $result;
    }

    public function pengumuman()
    {
        $data=Proposal::select('pengajuan_ormawa.*','ormawa.*', 'pengajuan_ormawa.id as id_pengajuan')
        ->leftjoin('ormawa','pengajuan_ormawa.ormawa_id','=', 'ormawa.id')
        ->get();
        return view ('Bem.pengumpulan', compact('data'));
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
        return view('Bem.create' , compact('ormawa'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'ormawa_id' => 'required',
            'nama_kegiatan' => 'required',
            'jenis_kegiatan' => 'required',
            'tema_kegiatan' => 'required',
            'tanggal_kegiatan' => 'required',
            'total_dana' => 'required',
            'lampiran' => 'required|mimes:pdf,docx|max:5120'
        ]);

        $filename = date('d-m-Y').'_'.$request->file('lampiran')->getClientOriginalName();  
        $path = $request->lampiran->move(public_path('data_proposal'), $filename);

        $data = Proposal::create([
            'ormawa_id' => $request->ormawa_id,
            'user_id'=>Auth()->user()->id,
            'nama_kegiatan' => $request->nama_kegiatan,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'tema_kegiatan' => $request->tema_kegiatan,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'total_dana' => $request->total_dana,
            'lampiran' => $filename,
        ]);

        return redirect()->route('list-pengajuan-bem')->with('toast_success', 'Data Berhasil Tersimpan');
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
        $ormawa = Ormawa::all();
        $data = DB::table('pengajuan_ormawa')->where('id', $id)->first();
        return view('Bem.edit', compact('data','ormawa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ormawa_id' => 'required',
            'nama_kegiatan' => 'required',
            'jenis_kegiatan' => 'required',
            'tema_kegiatan' => 'required',
            'tanggal_kegiatan' => 'required',
            'total_dana' => 'required',
            'lampiran' => 'required|mimes:pdf,docx|max:5120'
        ]);

        $ormawa = Ormawa::all();
        $Proposal = Proposal::where('id', $id)->first();    
        if ($request->file != Null){
              // $request->file->unlink(public_path('upload'), $Proposal->lampiran);
               $file_path = public_path().'/data_proposal/'.$Proposal->lampiran;
               unlink($file_path);

             $filename = date('d-m-Y').'_'.$request->file('lampiran')->getClientOriginalName();  
            $path = $request->lampiran->move(public_path('data_proposal'), $filename);
        $ormawa = Ormawa::all();
        DB::table('pengajuan_ormawa') -> where('id', $id) 
        -> update([
        'ormawa_id' => $request->ormawa_id,
        'nama_kegiatan' => $request->nama_kegiatan,
        'jenis_kegiatan' => $request->jenis_kegiatan,
        'tema_kegiatan' => $request->tema_kegiatan,
        'tanggal_kegiatan' => $request->tanggal_kegiatan,
        'total_dana' => $request->total_dana,
        'lampiran' => $filename,
        ]);

        return redirect()->route('list-pengajuan-bem')->with('toast_success', 'Data Berhasil Dirubah');
    }
        $ormawa = Ormawa::all();
        DB::table('pengajuan_ormawa') -> where('id', $id) 
        -> update([
            'ormawa_id' => $request->ormawa_id,
            'nama_kegiatan' => $request->nama_kegiatan,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'tema_kegiatan' => $request->tema_kegiatan,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'total_dana' => $request->total_dana,
        ]);
        return redirect()->route('list-pengajuan-bem')->with('toast_success', 'Data Berhasil Dirubah');
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
        return redirect()->route('list-pengajuan-bem')->with('toast_success', 'Data Berhasil DiHapus');
            
     
    }
}
