<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalDefaultElement extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'name',
        'description',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
