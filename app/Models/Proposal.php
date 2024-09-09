<?php

namespace App\Models;

use App\Services\UniqueIdentifierService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_number',
        'is_amendment',
        'parent_proposal_id',
        'description',
        'supplementalInfo',
        'formula_id', // Mise à jour du champ formula à formula_id
        'options_included',
        'additional_options',
        'services',
        'amount',
        'issue_date',
        'expiry_date',
        'customer_id',
        'status_id',
        'archived',
        'created_by',
        'updated_by',
    ];

    // Relation avec le client
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relation avec la formule
    public function formula()
    {
        return $this->belongsTo(Formula::class);
    }

    // Si vous avez une relation avec `ProposalCustomOption`
    public function customOptions()
    {
        return $this->hasMany(ProposalCustomOption::class, 'proposal_id');
    }

    // Générer automatiquement un numéro de proposition lors de la création (optionnel)
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($proposal) {
            if (empty($proposal->proposal_number)) {
                $proposal->proposal_number = UniqueIdentifierService::generateProposalNumber($proposal->customer->customer_number);
            }
        });
    }
}
