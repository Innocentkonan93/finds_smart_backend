<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
    use Illuminate\Support\Facades\Storage;
use App\Notifications\DocValidatedNotification;
class DocumentController extends Controller
{
    //
    public function documentsList()
    {
        $documents = Document::paginate(10);
        return view('admin.documents.documentsList', compact('documents'));
    }

    public function viewDocument($id)
    {
        $document = Document::find($id);
        return view('admin.documents.viewDocument', compact('document'));
    }

    public function deleteDocument($id)
    {
        $document = Document::find($id);
        if ($document) {
            Storage::delete($document->file_path);
            $document->delete();
            return redirect()->route('documentsList')->with('success', 'Document supprimé avec succès');
        }
        return redirect()->route('documentsList')->with('error', 'Document non trouvé');
    }

    public function updateDocument($id, Request $request)
    {
        $document = Document::find($id);
        $document->update($request->all());
        if ($request->is_validated == 1) {
            $document->is_validated = 1;
            $document->save();
            $document->user->notify(new DocValidatedNotification($document));
        }
        return redirect()->route('documentsList')->with('success', 'Document mis à jour avec succès');
    }

    public function validateDocument($id)
    {
        $document = Document::find($id);
        $document->is_validated = 1;
        $document->save();
        return redirect()->route('documentsList')->with('success', 'Document validé avec succès');
    }
}
