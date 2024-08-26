<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\CustomerNumberService;
use App\Services\UniqueIdentifierService;

class Customer extends Model
{
    use HasFactory;

    // Définir les champs remplissables
    protected $fillable = [
        'customer_number',
        'civility_id',
        'company_name',
        'last_name',
        'first_name',
        'phone',
        'email',
        'address',
        'postal_code',
        'city',
        'country',
        'additional_info',
        'status_id',
        'user_id',
        'created_by',
        'updated_by',
    ];

    // Casts automatiques des attributs
    protected $casts = [
        'civility_id' => 'integer',
        'status_id' => 'integer',
        'user_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    // Relation avec Civility
    public function civility()
    {
        return $this->belongsTo(Civility::class, 'civility_id');
    }

    // Relation avec Status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    // Relation avec User (associé au client)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation avec User (créé par)
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relation avec User (mis à jour par)
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Méthode boot pour générer automatiquement un customer_number lors de la création
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            $customer->customer_number = UniqueIdentifierService::generateCustomerNumber();
        });
    }
}
