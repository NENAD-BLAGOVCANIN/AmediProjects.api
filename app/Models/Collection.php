<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name', 'project_manager_mobile', 'accounting_manager_mobile', 'email', 'last_execution_date', 'agreed_payment_date',
        'contact_person', 'debt', 'first_line_sent_whatsapp', 'details', 'second_line_sent_email_details', 'whatsapp_2', 'details_2', 
        'call_2_created', 'collected_amount', 'remaining_amount_to_collect', 'company_name', 'cumulative_offset', 
        'offset_instead_of_guarantee', 'paymnet_plus','payment_status', 'last_connection' , 'last_invoice_issuance_date' , 'collection_contact' , 'amount_collected_this_month',
        'is_archived' , 'last_invoice_issue_date', 'last_detail_sent_date','offset_instead_of_guarantee_before_vat','guarantee_end_date',
    ];
}
