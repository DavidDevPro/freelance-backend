<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProposalRequestController extends Controller
{
  public function store(Request $request)
  {
    $data = $request->all();

    // Créer un dossier unique pour chaque demande de devis
    $directory = 'public/proposal_requests/' . uniqid();
    Storage::makeDirectory($directory);

    // Déplacer les fichiers de temp vers le dossier final
    foreach (['fileInput0', 'fileInput1', 'fileInput2'] as $fileKey) {
      if ($request->has($fileKey)) {
        $filename = $request->input($fileKey);
        Storage::move('public/temp/' . $filename, "$directory/$filename");
      }
    }

    // Sauvegarder la demande de devis dans la base de données...

    return response()->json(['message' => 'Votre demande de devis a été soumise avec succès !']);
  }
}
