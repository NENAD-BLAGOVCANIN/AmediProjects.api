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

            $imageUrl = $user->profile_image ? asset('storage/' . $imagePath) : null;
            $user->profile_image = $imageUrl;
            $user->save();
        }


        return response()->json(['message' => 'Profile image updated successfully', 'profile_image' => $imageUrl]);
    }

    public function updateProjectImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'project_id' => 'required|exists:projects,id'
        ]);

        $project_id = $request->get('id');
        $project = Project::findOrFail($project_id);

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');

            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }

            $imageUrl = $project->image ? asset('storage/' . $imagePath) : null;
            $project->profile_image = $imageUrl;
            $project->save();
        }


        return response()->json(['message' => 'Image updated successfully', 'image' => $imageUrl]);
    }
}
