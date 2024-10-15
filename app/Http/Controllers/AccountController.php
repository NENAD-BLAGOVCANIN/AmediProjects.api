<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountDetail;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'clientName' => 'required|string',
            'projectName' => 'required|string',
            'company' => 'required|string',
            'project_id' => 'required|exists:projects,id',
            'city' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'required|email',
            'createdBy' => 'required|string',
            'products' => 'required|array',
            'products.*.productName' => 'required|string',
            'products.*.unitOfMeasure' => 'required|string',
            'products.*.quantity' => 'required|integer',
            'products.*.unitPrice' => 'required|numeric',
            'products.*.total' => 'required|numeric',
            // אם יש לך works, תוסיף גם אותם כאן
        ]);

        // Create the account
        $account = Account::create([
            'client_name' => $validatedData['clientName'],
            'project_name' => $validatedData['projectName'],
            'company' => $validatedData['company'],
            'city' => $validatedData['city'],
            'phone' => $validatedData['phone'] ?? null,
            'email' => $validatedData['email'],
            'created_by' => $validatedData['createdBy'],
            'project_id' => $validatedData['project_id'],
        ]);

        // Create account details
        foreach ($validatedData['products'] as $product) {
            AccountDetail::create([
                'account_id' => $account->id,
                'project_id' => $validatedData['project_id'], 
                'product_name' => $product['productName'],
                'unit_of_measure' => $product['unitOfMeasure'],
                'quantity' => $product['quantity'],
                'unit_price' => $product['unitPrice'],
                'total' => $product['total'],
            ]);
        }

        // אם יש לך works, תטפל בהם כאן

        return response()->json(['message' => 'Account created successfully'], 201);
    }

    public function getAccountsSummary()
    {
        $accounts = Account::with('accountDetails')->get();
    
        // עיבוד הנתונים לפי הצורך
    
        return response()->json($accounts);
    }
}
