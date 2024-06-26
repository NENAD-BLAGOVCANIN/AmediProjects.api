<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class ProfileImageController extends Controller
{
    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');

            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $imageUrl = asset('storage/' . $imagePath);
            $user->profile_image = $imageUrl;
            $user->save();
        }


        return response()->json(['message' => 'Profile image updated successfully', 'profile_image' => $imageUrl]);
    }

    public function updateProjectImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'project_id' => 'required|exists:projects,id'
        ]);

        $project_id = $request->get('project_id');
        $project = Project::findOrFail($project_id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');

            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }

            $imageUrl = asset('storage/' . $imagePath);
            $project->image = $imageUrl;
            $project->save();
        }


        return response()->json(['message' => 'Image updated successfully', 'image' => $imageUrl]);
    }
}
