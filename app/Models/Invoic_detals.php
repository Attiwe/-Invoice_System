<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoic_detals extends Model
{
    use HasFactory;
    protected $fillable=[
        'id_Invoice',
        'invoice_number',
        'product',
        'Section',
        'Status',
        'Value_Status',
        'Payment_Date',
        'note',
        'user',
    ];
    
}
