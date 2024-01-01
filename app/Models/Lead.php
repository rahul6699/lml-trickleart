<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id','interested_in', 'source_id', 'lead_status_id', 'remark','status'
    ];

    public function Client() : BelongsTo {
        return $this->belongsTo(Client::class,'client_id');
    } 
    
    public function Source() : BelongsTo {
        return $this->belongsTo(Source::class,'source_id');
    } 
    
    public function LeadStatus() : BelongsTo {
        return $this->belongsTo(LeadStatus::class,'lead_status_id');
    } 
}
