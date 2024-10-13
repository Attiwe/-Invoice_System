<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
          'invoice_number',
          'section_id',
           'invoice_Date',
          'due_date',
          'amount_collection',
          'amount_commission',
          'product',
          'section_id',
          'discoun',
          'rate_vat',
          'value_vat',
          'total',
          'status',
          'value_status',
          'note',
          'user',
          //   'payment_Date',
     ];
     protected $dates = ['deleted_at'];

     public function section()
     {
         return $this->belongsTo(Section::class, 'section_id');
     }
     
 
    }
