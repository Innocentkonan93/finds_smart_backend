<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use App\Models\Job;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    //
    public function jobsList()
    {
        $jobCategories = JobCategory::paginate(10);
        return view('admin.jobs.jobsList', compact('jobCategories'));
    }
    
    public function viewJob($id)
    {
        $job = JobCategory::findOrFail($id);
        return view('admin.jobs.viewJob', compact('job'));
    }

    public function addJob()
    {
        $jobCategories = JobCategory::all();
        return view('admin.jobs.addJob', compact('jobCategories'));
    }

    public function storeJob(Request $request)
    {
        $job = JobCategory::create($request->all());
        return redirect()->route('jobsList')->with('success', 'Job créé avec succès');
    }

    public function updateJob(Request $request, $id)
    {
        $job = JobCategory::findOrFail($id);
        $job->update($request->all());
        return redirect()->route('jobsList')->with('success', 'Job mis à jour avec succès');
    }
    

    public function deleteJob(Request $request, $id)
    {
        $job = JobCategory::findOrFail($id);
        $job->delete();
        return redirect()->route('jobsList')->with('success', 'Job supprimé avec succès');
    }
    
}
