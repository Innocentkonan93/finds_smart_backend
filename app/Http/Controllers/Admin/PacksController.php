<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pack;
use App\Models\Service;
class PacksController extends Controller
{
    //
    public function packsList()
    {
        $packs = Pack::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.packs.packsList', compact('packs'));
    }

    public function viewPack($id)
    {
        $pack = Pack::find($id);
        return view('admin.packs.viewPack', compact('pack'));
    }

    public function addPack()
    {
        return view('admin.packs.addPack');
    }

    public function storePack(Request $request)
    {
        $pack = Pack::create($request->all());
        return redirect()->route('packsList')->with('success', 'Pack créé avec succès');
    }

    public function updatePack(Request $request, $id)
    {
        $pack = Pack::find($id);
        $pack->update($request->all());
        return redirect()->route('packsList')->with('success', 'Pack mis à jour avec succès');
    }

    public function deletePack($id)
    {
        $pack = Pack::find($id);
        $pack->delete();
        return redirect()->route('packsList')->with('success', 'Pack supprimé avec succès');
    }
}
