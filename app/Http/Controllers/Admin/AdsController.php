<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\JobCategory;
use App\Models\User;
use Illuminate\Http\Request;


class AdsController extends Controller
{
    //
    public function adsList()
    {
        $ads = Ad::with(['user', 'category'])->paginate(10);
        $jobCategories = JobCategory::all();
        $clients = User::where('user_type', 'client')->get();
        return view('admin.ads.adsList', compact('ads', 'jobCategories', 'clients'));
    }

    public function viewAd($id)
    {
        $ad = Ad::with(['user', 'category'])->findOrFail($id);
        return view('admin.ads.viewAd', compact('ad'));
    }

    public function addAd()
    {
        $jobCategories = JobCategory::all();
        return view('admin.ads.addAd', compact('jobCategories'));
    }

    public function storeAd(Request $request)
    {
        $ad = Ad::create($request->all());
        return redirect()->route('adsList')->with('success', 'Annonce créée avec succès');
    }
    
    public function updateAd(Request $request, $id)
    {
        $ad = Ad::findOrFail($id);
        $ad->update($request->all());
        return redirect()->route('adsList')->with('success', 'Annonce mise à jour avec succès');
    }

    public function deleteAd(Request $request, $id)
    {
        $ad = Ad::findOrFail($id);
        $ad->delete();
        return redirect()->route('adsList')->with('success', 'Annonce supprimée avec succès');
    }
    
}
