<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ContactsController extends Controller
{
    public function index(Request $request)
    {

        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $contacts = Contact::where('project_id', '=', $user->currently_selected_project_id)->orderBy('id', 'desc')->get();
        return response()->json($contacts);
    }

    public function store(Request $request)
    {

        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'title' => 'nullable|string',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'lead_source' => 'nullable|string',
            'past_client' => 'nullable|boolean',
            'phone' => 'nullable|string',
            'organization' => 'nullable|string',
        ]);

        $contact = Contact::create($validatedData);
        $contact->project_id = $user->currently_selected_project_id;
        $contact->save();

        return response()->json($contact, 201);
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return response()->json($contact);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'title' => 'nullable|string',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'lead_source' => 'nullable|string',
            'past_client' => 'nullable|boolean',
            'phone' => 'nullable|string',
            'organization' => 'nullable|string',
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update($validatedData);

        return response()->json($contact, 200);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response()->json(null, 204);
    }
}
