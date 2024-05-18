<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Contact;

class ClientsController extends Controller
{
    public function index()
    {

        $user = auth()->user();

        $clients = Client::whereHas('contact', function ($query) use ($user) {
            $query->where('project_id', '=', $user->currently_selected_project_id);
        })->with('contact')->orderBy('id', 'desc')->get();

        return response()->json($clients);
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'contact_id' => 'required|exists:contacts,id'
        ]);

        $client = Client::create($validatedData);
        $client->save();

        $newClient = Client::with('contact')->findOrFail($client->id);
        return response()->json($newClient, 201);
    }

    public function show($id)
    {
        $client = Client::findOrFail($id);
        return response()->json($client);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'description' => 'nullable|string',
            'client_source' => 'nullable|string',
        ]);

        $client = Client::findOrFail($id);
        $client->update($validatedData);

        return response()->json($client, 200);
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return response()->json(null, 204);
    }
}
