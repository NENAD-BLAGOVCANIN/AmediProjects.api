<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\AccountDetail;

class AccountDetailsController extends Controller
{
    public function storeAccountDetails(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'clientName' => 'required|string',
            'projectName' => 'required|string',
            'company' => 'required|string',
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
        ]);

        // Create account details
        foreach ($validatedData['products'] as $product) {
            AccountDetail::create([
                'account_id' => $account->id,
                'product_name' => $product['productName'],
                'unit_of_measure' => $product['unitOfMeasure'],
                'quantity' => $product['quantity'],
                'unit_price' => $product['unitPrice'],
                'total' => $product['total'],
            ]);
        }

        // אם יש לך works, תטפל בהם כאן

        return response()->json(['message' => 'Account details saved successfully'], 201);
    }
    public function getTotalAmountSent()
    {
        $totalAmount = AccountDetail::sum('total');
        return response()->json(['total_amount_sent' => $totalAmount]);
    }

}
