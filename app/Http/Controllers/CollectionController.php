<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Collection::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_name' => 'nullable|string',
            'project_manager_mobile' => 'nullable|string',
            'accounting_manager_mobile' => 'nullable|string',
            'email' => 'nullable|email',
            'last_execution_date' => 'nullable|string',
            'agreed_payment_date' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'debt' => 'nullable|string',
            'first_line_sent_whatsapp' => 'nullable|string',
            'details' => 'nullable|string',
            'second_line_sent_email_details' => 'nullable|string',
            'whatsapp_2' => 'nullable|string',
            'details_2' => 'nullable|string',
            'call_2_created' => 'nullable|string',
            'collected_amount' => 'nullable|string',
            'remaining_amount_to_collect' => 'nullable|string',
            'company_name' => 'nullable|string',
            'cumulative_offset' => 'nullable|string',
            'offset_instead_of_guarantee' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'last_connection' => 'nullable|string',
            'last_invoice_issuance_date'=> 'nullable|string', 
            'collection_contact'=> 'nullable|string', 
            'amount_collected_this_month' => 'nullable|string',
            'is_archived' => 'nullable|int',
        ]);

        return Collection::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Collection $collection)
    {
        return $collection;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Collection $collection)
    {
        $request->validate([
            'project_name' => 'nullable|string',
            'project_manager_mobile' => 'nullable|string',
            'accounting_manager_mobile' => 'nullable|string',
            'email' => 'nullable|email',
            'last_execution_date' => 'nullable|string',
            'agreed_payment_date' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'debt' => 'nullable|string',
            'first_line_sent_whatsapp' => 'nullable|string',
            'details' => 'nullable|string',
            'second_line_sent_email_details' => 'nullable|string',
            'whatsapp_2' => 'nullable|string',
            'details_2' => 'nullable|string',
            'call_2_created' => 'nullable|string',
            'collected_amount' => 'nullable|string',
            'remaining_amount_to_collect' => 'nullable|string',
            'company_name' => 'nullable|string',
            'cumulative_offset' => 'nullable|string',
            'offset_instead_of_guarantee' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'last_connection' => 'nullable|string',
            'last_invoice_issuance_date'=> 'nullable|string', 
            'collection_contact'=> 'nullable|string', 
            'amount_collected_this_month' => 'nullable|string',
            'is_archived' => 'nullable|int',
        ]);

        $collection->update($request->all());

        return $collection;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection)
    {
        $collection->delete();

        return response()->json(['message' => 'Collection deleted successfully']);
    }
}
