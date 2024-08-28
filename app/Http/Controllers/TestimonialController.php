<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Services\MailService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Helpers\EmailHelper;

class TestimonialController extends Controller
{
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * @OA\Get(
     *     path="/api/testimonials",
     *     summary="Afficher une liste des témoignages",
     *     operationId="getTestimonials",
     *     tags={"Testimonials"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des témoignages",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Testimonial"))
     *     )
     * )
     */
    public function index()
    {
        $testimonials = Testimonial::all();
        return response()->json($testimonials);
    }

    /**
     * @OA\Post(
     *     path="/api/testimonials",
     *     summary="Créer un nouveau témoignage",
     *     operationId="storeTestimonial",
     *     tags={"Testimonials"},
     *     @OA\RequestBody(
     *         description="Données nécessaires pour créer un témoignage",
     *         required=true,
     *         @OA\JsonContent(
     *             required={"firstName", "lastName", "email", "role", "comment"},
     *             @OA\Property(property="firstName", type="string", example="John"),
     *             @OA\Property(property="lastName", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="role", type="string", example="CEO"),
     *             @OA\Property(property="comment", type="string", example="Excellent service!"),
     *             @OA\Property(property="avatar", type="string", format="binary"),
     *             @OA\Property(property="avatarUrl", type="string", example="https://example.com/avatar.jpg"),
     *             @OA\Property(property="source", type="string", example="Website")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Témoignage créé avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Testimonial")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides"
     *     )
     * )
     */
    public function store(Request $request)
    {
        // Valider la requête
        $validatedData = $this->validateTestimonial($request);
    
        // Gérer l'avatar
        $avatarPath = $this->handleAvatarUpload($request);
    
        // S'assurer que la première lettre de firstName est en majuscule
        $validatedData['firstName'] = ucfirst(strtolower($validatedData['firstName']));

        // Mettre tout le lastName en majuscule
        $validatedData['lastName'] = strtoupper($validatedData['lastName']);

        // Créer le témoignage
        $testimonial = $this->createTestimonial($validatedData, $avatarPath, $request->input('rating', 5.0));
    
        // Envoyer les emails de confirmation et de notification
        $this->sendEmails($validatedData);
    
        return response()->json(['message' => 'Témoignage créé avec succès', 'testimonial' => $testimonial], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/testimonials/{id}",
     *     summary="Afficher un témoignage spécifique",
     *     operationId="getTestimonial",
     *     tags={"Testimonials"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID du témoignage",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails du témoignage",
     *         @OA\JsonContent(ref="#/components/schemas/Testimonial")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Témoignage non trouvé"
     *     )
     * )
     */
    public function show(Testimonial $testimonial)
    {
        return response()->json($testimonial);
    }

    /**
     * @OA\Put(
     *     path="/api/testimonials/{id}",
     *     summary="Mettre à jour un témoignage existant",
     *     operationId="updateTestimonial",
     *     tags={"Testimonials"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID du témoignage",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Données nécessaires pour mettre à jour un témoignage",
     *         required=true,
     *         @OA\JsonContent(
     *             required={"firstName", "lastName", "role", "comment"},
     *             @OA\Property(property="firstName", type="string", example="John"),
     *             @OA\Property(property="lastName", type="string", example="Doe"),
     *             @OA\Property(property="role", type="string", example="CEO"),
     *             @OA\Property(property="comment", type="string", example="Excellent service!"),
     *             @OA\Property(property="avatar", type="string", format="binary"),
     *             @OA\Property(property="source", type="string", example="Website")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Témoignage mis à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Testimonial")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Témoignage non trouvé"
     *     )
     * )
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        // Valider la requête
        $validatedData = $this->validateTestimonial($request);

        // Gérer le changement d'avatar
        $this->updateAvatar($request, $testimonial);

        // Mettre à jour les autres champs du témoignage
        $testimonial->update([
            'firstName' => ucfirst(strtolower($validatedData['firstName'])),
            'lastName' => strtoupper($validatedData['lastName']),
            'role' => $validatedData['role'],
            'comment' => $validatedData['comment'],
            'rating' => $request->input('rating', $testimonial->rating),
            'source' => $validatedData['source'] ?? $testimonial->source,
        ]);

        return response()->json(['message' => 'Témoignage mis à jour avec succès', 'testimonial' => $testimonial]);
    }

    /**
     * @OA\Delete(
     *     path="/api/testimonials/{id}",
     *     summary="Supprimer un témoignage existant",
     *     operationId="deleteTestimonial",
     *     tags={"Testimonials"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID du témoignage",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Témoignage supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Témoignage supprimé avec succès")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Témoignage non trouvé"
     *     )
     * )
     */
    public function destroy(Testimonial $testimonial)
    {
        // Supprimer l'avatar associé, le cas échéant
        $this->deleteAvatar($testimonial);

        $testimonial->delete();

        return response()->json(['message' => 'Témoignage supprimé avec succès']);
    }

    /**
     * Valider les données du témoignage
     */
    protected function validateTestimonial(Request $request)
    {
        return $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string|min:2|max:255',
            'comment' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'avatarUrl' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:255'
        ]);
    }

    /**
     * Gérer l'upload de l'avatar
     */
    protected function handleAvatarUpload(Request $request)
    {
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('public/testimonial_images');
            return basename($avatarPath);
        } else {
            return $this->copyDefaultAvatar();
        }
    }

    /**
     * Copier l'avatar par défaut
     */
    protected function copyDefaultAvatar()
    {
        $defaultAvatarPath = 'public/profile_images/defaut.jpg';
        $generatedAvatarName = Str::uuid() . '.jpg';
        $destinationPath = 'public/testimonial_images/' . $generatedAvatarName;

        if (Storage::exists($defaultAvatarPath) && Storage::copy($defaultAvatarPath, $destinationPath)) {
            return $generatedAvatarName;
        } else {
            throw new \Exception('Failed to copy default avatar');
        }
    }

    /**
     * Mettre à jour l'avatar du témoignage
     */
    protected function updateAvatar(Request $request, Testimonial $testimonial)
    {
        if ($request->hasFile('avatar')) {
            if ($testimonial->image_url) {
                Storage::delete('public/testimonial_images/' . basename($testimonial->image_url));
            }
            $avatarPath = $request->file('avatar')->store('public/testimonial_images');
            $testimonial->image_url = basename($avatarPath);
        } elseif ($request->input('avatarUrl')) {
            $testimonial->image_url = basename($request->input('avatarUrl'));
        }
    }

    /**
     * Supprimer l'avatar associé au témoignage
     */
    protected function deleteAvatar(Testimonial $testimonial)
    {
        if ($testimonial->image_url) {
            Storage::delete('public/testimonial_images/' . basename($testimonial->image_url));
        }
    }

    /**
     * Créer un nouveau témoignage
     */
    protected function createTestimonial(array $validatedData, $avatarPath, $rating)
    {
        return Testimonial::create([
            'name' => trim($validatedData['firstName'] . ' ' . $validatedData['lastName']),
            'role' => $validatedData['role'],
            'comment' => $validatedData['comment'],
            'image_url' => $avatarPath,
            'rating' => $rating,
            'source' => $validatedData['source'] ?? null
        ]);
    }

    /**
     * Envoyer les emails de confirmation et de notification
     */
    protected function sendEmails(array $validatedData)
    {
        EmailHelper::sendEmail($this->mailService, 'testimonial_confirmation', $validatedData);
        EmailHelper::sendEmail($this->mailService, 'testimonial_notification', $validatedData);
    }
}
