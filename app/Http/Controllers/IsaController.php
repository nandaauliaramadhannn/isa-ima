<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Isa;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class IsaController extends Controller
{
    public function index()
    {
        $isas = Isa::latest()->get();
        return view('isa.index', compact('isas'));
    }

    public function create()
    {
        return view('isa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string',
            'platform' => 'required|in:twitter,instagram,tiktok',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);
        try{
            $isa = Isa::create([
            'keyword' => $request->keyword,
            'platform' => $request->platform,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'created_by' => auth()->id(),
            ]);
            Alert::toast('ISA berhasil dibuat', 'success');
            return redirect()->route('isa.index');
        }catch(Exception $e){
            Alert::toast('Gagal membuat ISA: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}
