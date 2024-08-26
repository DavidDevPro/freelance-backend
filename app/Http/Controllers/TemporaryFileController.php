<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TemporaryFileController extends Controller
{
    /**
     * Gérer la requête entrante pour stocker un fichier temporaire.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Valider le fichier reçu
        $validatedData = $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:3072', // 3MB max, types spécifiques
        ]);

        // Récupérer le fichier depuis la requête validée
        $file = $validatedData['file'];

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
