<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoic_attachments extends Model
{
    use HasFactory;
     protected $fillable = ['file_name','invoice_number','Created_by','invoice_id'];
     public function invoice():BelongsTo{
        return $this->belongsTo(Invoice::class);
    }  
}
