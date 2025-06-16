<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pack;
use App\Models\Service;
use App\Http\Requests\StorePackRequest;
use App\Http\Requests\UpdatePackRequest;

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

    public function storePack(StorePackRequest $request)
    {
        $validated = $request->validated();
        if(!$validated){
            return redirect()->route('packsList')->with('error', 'Erreur lors de la création du pack');
        }
        
        $validated['highlight'] = $request->highlight ? true : false;
        
        if($validated['highlight']) {
            Pack::where('type', $validated['type'])
                ->where('highlight', 1)
                ->update(['highlight' => false]);
        }
        
        $pack = Pack::create($validated);
        return redirect()->route('packsList')->with('success', 'Pack créé avec succès');
    }

    public function updatePack(UpdatePackRequest $request, $id)
    {
        $pack = Pack::find($id);
        $validated = $request->validated();

        if(!$validated){
            return redirect()->route('packsList')->with('error', 'Erreur lors de la mise à jour du pack');
        }
        $pack->update($validated);
        return redirect()->route('packsList')->with('success', 'Pack mis à jour avec succès');
    }

    public function deletePack($id)
    {
        $pack = Pack::find($id);
        $pack->delete();
        return redirect()->route('packsList')->with('success', 'Pack supprimé avec succès');
    }
}
