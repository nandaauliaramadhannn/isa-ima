<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Ima;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ImaController extends Controller
{
    public function index()
    {
        $imas = Ima::latest()->get();
        return view('ima.index', compact('imas'));
    }

    public function create()
    {
        return view('ima.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sumber_media' => 'required|string',
            'keyword' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);
        try{
            $ima = Ima::create([
            'sumber_media' => $request->sumber_media,
            'keyword' => $request->keyword,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'created_by' => auth()->id(),
            ]);
            Alert::toast('IMA berhasil dibuat', 'success');
            return redirect()->route('ima.index');
        }catch(Exception $e){
            Alert::toast('Gagal membuat IMA: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}
