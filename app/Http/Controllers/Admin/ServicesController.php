<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
class ServicesController extends Controller
{
    //
    public function servicesList()
    {
        $services = Service::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.services.servicesList', compact('services'));
    }

    public function viewService($id)
    {
        $service = Service::find($id);
        return view('admin.services.viewService', compact('service'));
    }

    public function addService()
    {
        return view('admin.services.addService');
    }

    public function storeService(Request $request)
    {
        $service = Service::create($request->all());
        return redirect()->route('servicesList')->with('success', 'Service créé avec succès');
    }

    public function updateService(Request $request, $id)
    {
        $service = Service::find($id);
        $service->update($request->all());
        return redirect()->route('servicesList')->with('success', 'Service mis à jour avec succès');
    }

    public function deleteService($id)
    {
        $service = Service::find($id);
        $service->delete();
        return redirect()->route('servicesList')->with('success', 'Service supprimé avec succès');
    }
}
