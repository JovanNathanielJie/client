<?php

namespace App\Http\Controllers;

use App\Models\Adventure;
use Illuminate\Http\Request;

class AdventureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adventures = Adventure::orderBy('created_at', 'desc')->get();
        return view('adventure.index', compact('adventures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kegiatan' => 'required|string|max:255',
            'rencana_kapan' => 'required|string|max:255',
            'deskripsi_kegiatan' => 'required|string',
        ]);

        Adventure::create($validated);
        return redirect('/adventure')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'kegiatan' => 'required|string|max:255',
            'rencana_kapan' => 'required|string|max:255',
            'deskripsi_kegiatan' => 'required|string',
        ]);

        $adventure = Adventure::findOrFail($id);
        $adventure->update($validated);
        return redirect('/adventure')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $adventure = Adventure::findOrFail($id);
        $adventure->delete();
        return redirect('/adventure')->with('success', 'Kegiatan berhasil dihapus!');
    }
}

