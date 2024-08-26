<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // Nom de la table associée
    protected $table = 'companies';

    // Attributs assignables en masse
    protected $fillable = [
        'company_name',
        'phone',
        'email',
        'address',
        'postal_code',
        'city',
        'siret',
        'ape_code',
        'iban',
        'header_text',
        'footer_text',
        'created_by',
        'updated_by',
    ];

    // Relation avec le modèle User pour le champ created_by
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relation avec le modèle User pour le champ updated_by
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
