<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    //
    // public function index()
    // {
    //     $pages = Page::all();
    //     return view('admin.pages.index', compact('pages'));
    // }

    public function termsCondition()
    {
        $page = Page::where('slug', 'terms')->first();
        return view('admin.pages.termsCondition', compact('page'));
    }

    public function privacyPolicy()
    {
        $page = Page::where('slug', 'privacy')->first();
        return view('admin.pages.privacyPolicy', compact('page'));
    }


    public function editTermsCondition()
    {
        $page = Page::where('slug', 'terms')->first();
        
        return view('admin.pages.editTermsCondition', compact('page'));
    }

    public function updateTermsCondition(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $page = Page::find($id);
        $page->update($request->only('title', 'content', 'is_active'));

        return redirect()->back()->with('success', 'Termes & Conditions mise à jour !');
    }

    public function editPrivacyPolicy()
    {
        $page = Page::where('slug', 'privacy')->first();
        return view('admin.pages.editPrivacyPolicy', compact('page'));
    }

    public function updatePrivacyPolicy(Request $request, $id)      
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $page = Page::find($id);
        $page->update($request->only('title', 'content', 'is_active'));

        return redirect()->back()->with('success', 'Politique de confidentialité mise à jour !');
    }

}
