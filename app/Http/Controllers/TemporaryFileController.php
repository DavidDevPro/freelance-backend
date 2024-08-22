<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TemporaryFileController extends Controller
{
    /**
     * Handle the incoming request to store a temporary file.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Valider le fichier reçu
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:3072', // 3MB max, type spécifique
        ]);

        // Récupérer le fichier depuis la requête
        $file = $request->file('file');

        // Générer un nom de fichier unique
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        // Stocker le fichier dans un dossier temporaire sous 'public/proposal_request/temporary'
        $file->storeAs('public/proposal_request/temporary', $filename);

        // Retourner la réponse avec le nom du fichier
        return response()->json([
            'filename' => $filename,
            'message' => 'Fichier uploadé temporairement avec succès.',
        ]);
    }
}
