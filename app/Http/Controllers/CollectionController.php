<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $timestamps = false;

    public function updateArchiveStatus(Request $request, $id)
    {
        $collection = Collection::findOrFail($id);
        $collection->is_archive = $request->is_archive;
        $collection->save();

        return response()->json(['message' => 'Archive status updated successfully']);
    }
 
    public function getCollectionSummary()
    {
        $summary = MonthlyCollection::selectRaw('project_id, SUM(amount_collected) as total_collected')
            ->groupBy('project_id')
            ->get();
    
        return response()->json($summary);
    }
    
    public function index()
    {
        return Collection::all();
    }

    public function getSumOfDebt()
    {
         $sumOfDebt = Collection::where('is_archive', 0)->sum('debt');
        return response()->json(['sum_of_debt' => $sumOfDebt]);
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
            'paymnet_plus' => 'nullable|string',
            'remaining_amount_to_collect' => 'nullable|string',
            'company_name' => 'nullable|string',
            'retention_5' => 'nullable|string',
            'cumulative_offset' => 'nullable|string',
            'offset_instead_of_guarantee' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'last_connection' => 'nullable|string',
            'last_invoice_issuance_date'=> 'nullable|string', 
            'collection_contact'=> 'nullable|string', 
            'amount_collected_this_month' => 'nullable|string',
            'is_archived' => 'nullable|int',
            'have_problem' => 'nullable|int',
            'last_invoice_issue_date'=> 'nullable|string',
            'last_detail_sent_date'=> 'nullable|string',
            'offset_instead_of_guarantee_before_vat'=> 'nullable|string',
            'guarantee_end_date'=> 'nullable|string',
        ]);

        $data = $request->all();
        $data['is_archive'] = false;

        return Collection::create($data);
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
            'paymnet_plus' => 'nullable|string',
            'debt' => 'nullable|string',
            'first_line_sent_whatsapp' => 'nullable|string',
            'details' => 'nullable|string',
            'retention_5' => 'nullable|string',
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
            'last_invoice_issue_date'=> 'nullable|string',
            'last_detail_sent_date'=> 'nullable|string',
            'offset_instead_of_guarantee_before_vat'=> 'nullable|string',
            'guarantee_end_date'=> 'nullable|string',
            'have_problem'=>'nullable|int',
        ]);

        $collection->update($request->all());

        return $collection;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection)
    {
        $collection->is_archive = true;
        $collection->save();

        return response()->json(['message' => 'Collection archived successfully']);
    }
        public function getWeeklyCollectionsCount()
    {
        $count = Collection::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        return response()->json(['weekly_collections_count' => $count]);
    }

    public function getAmountCollectedPerMonth()
{
    $collections = MonthlyCollection::select('year', 'month', DB::raw('SUM(amount_collected) as total_amount'))
                    ->groupBy('year', 'month')
                    ->orderBy('year', 'month')
                    ->get();

    return response()->json(['amount_collected_per_month' => $collections]);
}


}
