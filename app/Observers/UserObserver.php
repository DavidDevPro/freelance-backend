<?php

namespace App\Observers;

use App\Models\User;
use App\Services\UniqueIdentifierService;

class UserObserver
{
    /**
     * Événement déclenché avant la création d'un nouvel utilisateur.
     */
    public function creating(User $user)
    {
        // Si l'identifiant n'est pas déjà défini, on le génère
        if (empty($user->identifiant)) {
            $user->identifiant = UniqueIdentifierService::generateIdentifier($user->firstName, $user->lastName);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
