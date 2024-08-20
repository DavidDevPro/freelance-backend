<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $testimonials = Testimonial::all();
    return response()->json($testimonials);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|min:2',
      'role' => 'required|string|min:2',
      'description' => 'required|string',
      'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
      'avatarUrl' => 'nullable|string',
      'source' => 'nullable|string'
    ]);

    $avatarPath = null;
    if ($request->hasFile('avatar')) {
      $avatarPath = $request->file('avatar')->store('public/testimonial_images');
      $avatarPath = basename($avatarPath); // Ne conserver que le nom de fichier
    } else {
      // Copier l'avatar par défaut dans le dossier approprié avec un nom généré
      $defaultAvatarPath = 'public/profile_images/defaut.jpg';
      $generatedAvatarName = Str::uuid() . '.jpg';
      $destinationPath = 'public/testimonial_images/' . $generatedAvatarName;

      if (Storage::exists($defaultAvatarPath) && Storage::copy($defaultAvatarPath, $destinationPath)) {
        $avatarPath = $generatedAvatarName;
      } else {
        // Gérer le cas où la copie échoue
        return response()->json(['message' => 'Failed to copy default avatar'], 500);
      }
    }

    $testimonial = Testimonial::create([
      'name' => $request->input('name'),
      'role' => $request->input('role'),
      'description' => $request->input('description'),
      'image_url' => $avatarPath,
      'rating' => $request->input('rating', 5.0),
      'source' => $request->input('source')
    ]);

    return response()->json(['message' => 'Testimonial created successfully', 'testimonial' => $testimonial], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Testimonial  $testimonial
   * @return \Illuminate\Http\Response
   */
  public function show(Testimonial $testimonial)
  {
    return response()->json($testimonial);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Testimonial  $testimonial
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Testimonial $testimonial)
  {
    $request->validate([
      'name' => 'required|string|min:2',
      'role' => 'required|string|min:2',
      'description' => 'required|string',
      'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
      'source' => 'nullable|string'
    ]);

    if ($request->hasFile('avatar')) {
      if ($testimonial->image_url) {
        $oldAvatarPath = 'public/testimonial_images/' . basename($testimonial->image_url);
        Storage::delete($oldAvatarPath);
      }

      $avatarPath = $request->file('avatar')->store('public/testimonial_images');
      $avatarPath = basename($avatarPath); // Ne conserver que le nom de fichier
      $testimonial->image_url = $avatarPath;
    } elseif ($request->input('avatarUrl')) {
      $testimonial->image_url = basename($request->input('avatarUrl')); // Ne conserver que le nom de fichier
    }

    $testimonial->name = $request->input('name');
    $testimonial->role = $request->input('role');
    $testimonial->description = $request->input('description');
    $testimonial->rating = $request->input('rating', $testimonial->rating);
    $testimonial->source = $request->input('source');

    $testimonial->save();

    return response()->json(['message' => 'Testimonial updated successfully', 'testimonial' => $testimonial]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Testimonial  $testimonial
   * @return \Illuminate\Http\Response
   */
  public function destroy(Testimonial $testimonial)
  {
    // Delete the avatar file if exists
    if ($testimonial->image_url) {
      $avatarPath = 'public/testimonial_images/' . basename($testimonial->image_url);
      Storage::delete($avatarPath);
    }

    $testimonial->delete();

    return response()->json(['message' => 'Testimonial deleted successfully']);
  }
}
