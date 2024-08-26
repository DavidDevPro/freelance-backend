<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    /**
     * Afficher une liste des témoignages.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $testimonials = Testimonial::all();
        return response()->json($testimonials);
    }

    /**
     * Créer un nouveau témoignage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Valider la requête
        $validatedData = $request->validate([
            'name' => 'required|string|min:2',
            'role' => 'required|string|min:2',
            'comment' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'avatarUrl' => 'nullable|string',
            'source' => 'nullable|string'
        ]);

        // Gérer le téléchargement de l'avatar ou l'utilisation d'un avatar par défaut
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('public/testimonial_images');
            $avatarPath = basename($avatarPath); // Ne conserver que le nom de fichier
        } else {
            $defaultAvatarPath = 'public/profile_images/defaut.jpg';
            $generatedAvatarName = Str::uuid() . '.jpg';
            $destinationPath = 'public/testimonial_images/' . $generatedAvatarName;

            if (Storage::exists($defaultAvatarPath) && Storage::copy($defaultAvatarPath, $destinationPath)) {
                $avatarPath = $generatedAvatarName;
            } else {
                return response()->json(['message' => 'Failed to copy default avatar'], 500);
            }
        }

        // Créer le témoignage
        $testimonial = Testimonial::create([
            'name' => $validatedData['name'],
            'role' => $validatedData['role'],
            'comment' => $validatedData['comment'],
            'image_url' => $avatarPath,
            'rating' => $request->input('rating', 5.0),
            'source' => $validatedData['source'] ?? null
        ]);

        return response()->json(['message' => 'Testimonial created successfully', 'testimonial' => $testimonial], 201);
    }

    /**
     * Afficher un témoignage spécifique.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Testimonial $testimonial)
    {
        return response()->json($testimonial);
    }

    /**
     * Mettre à jour un témoignage existant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        // Valider la requête
        $validatedData = $request->validate([
            'name' => 'required|string|min:2',
            'role' => 'required|string|min:2',
            'comment' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'source' => 'nullable|string'
        ]);

        // Gérer le changement d'avatar
        if ($request->hasFile('avatar')) {
            if ($testimonial->image_url) {
                $oldAvatarPath = 'public/testimonial_images/' . basename($testimonial->image_url);
                Storage::delete($oldAvatarPath);
            }

            $avatarPath = $request->file('avatar')->store('public/testimonial_images');
            $testimonial->image_url = basename($avatarPath);
        } elseif ($request->input('avatarUrl')) {
            $testimonial->image_url = basename($request->input('avatarUrl'));
        }

        // Mettre à jour les autres champs du témoignage
        $testimonial->update([
            'name' => $validatedData['name'],
            'role' => $validatedData['role'],
            'comment' => $validatedData['comment'],
            'rating' => $request->input('rating', $testimonial->rating),
            'source' => $validatedData['source'] ?? $testimonial->source,
        ]);

        return response()->json(['message' => 'Testimonial updated successfully', 'testimonial' => $testimonial]);
    }

    /**
     * Supprimer un témoignage existant.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Testimonial $testimonial)
    {
        // Supprimer l'avatar associé, le cas échéant
        if ($testimonial->image_url) {
            $avatarPath = 'public/testimonial_images/' . basename($testimonial->image_url);
            Storage::delete($avatarPath);
        }

        $testimonial->delete();

        return response()->json(['message' => 'Testimonial deleted successfully']);
    }
}
