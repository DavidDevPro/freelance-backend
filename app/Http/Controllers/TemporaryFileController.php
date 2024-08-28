<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TemporaryFileController extends Controller
{
    /**
     * @OA\Post(
     *     path="/proposal-request/temporary-upload",
     *     summary="Uploader un fichier temporaire",
     *     operationId="uploadTemporaryFile",
     *     tags={"Proposals-Request"},
     *     @OA\RequestBody(
     *         description="Fichier à uploader temporairement",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="file",
     *                     type="string",
     *                     format="binary",
     *                     description="Le fichier à uploader"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fichier uploadé temporairement avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="filename", type="string", example="123e4567-e89b-12d3-a456-426614174000.pdf"),
     *             @OA\Property(property="message", type="string", example="Fichier uploadé temporairement avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation des données échouée"
     *     )
     * )
     */
    public function store(Request $request)
    {
        // Valider le fichier reçu
        $validatedData = $this->validateFile($request);

        // Récupérer le fichier depuis la requête validée
        $file = $validatedData['file'];

        // Générer un nom de fichier unique
        $filename = $this->generateUniqueFilename($file);

        // Stocker le fichier dans un dossier temporaire sous 'public/proposal_request/temporary'
        $this->storeFileTemporarily($file, $filename);

        // Retourner la réponse avec le nom du fichier
        return $this->successResponse($filename);
    }

    /**
     * Valider le fichier reçu dans la requête.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function validateFile(Request $request)
    {
        return $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:3072', // 3MB max, types spécifiques
        ]);
    }

    /**
     * Générer un nom de fichier unique en utilisant UUID.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    protected function generateUniqueFilename($file)
    {
        return Str::uuid() . '.' . $file->getClientOriginalExtension();
    }

    /**
     * Stocker le fichier dans le dossier temporaire.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $filename
     * @return void
     */
    protected function storeFileTemporarily($file, $filename)
    {
        $file->storeAs('public/proposal_request/temporary', $filename);
    }

    /**
     * Retourner une réponse JSON de succès avec le nom du fichier.
     *
     * @param string $filename
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($filename)
    {
        return response()->json([
            'filename' => $filename,
            'message' => 'Fichier uploadé temporairement avec succès.',
        ]);
    }
}
