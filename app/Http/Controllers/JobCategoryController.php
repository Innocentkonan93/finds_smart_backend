<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobCategoryRequest;
use App\Http\Requests\UpdateJobCategoryRequest;
use App\Models\JobCategory;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobCategories = JobCategory::all();
        return response()->json([
            'status' => 'success',
            'jobCategories' => $jobCategories
        ], 200);
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
    public function store(StoreJobCategoryRequest $request)
    {
        $jobCategory = JobCategory::create($request->all());
        return response()->json([
            'status' => 'success',
            'jobCategory' => $jobCategory
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(JobCategory $jobCategory)
    {
        return response()->json([
            'status' => 'success',
            'jobCategory' => $jobCategory
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobCategory $jobCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobCategoryRequest $request, JobCategory $jobCategory)
    {
        $jobCategory->update($request->all());
        return response()->json([
            'status' => 'success',
            'jobCategory' => $jobCategory
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobCategory $jobCategory)
    {
        $jobCategory->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Job category deleted successfully'
        ], 200);
    }
}
