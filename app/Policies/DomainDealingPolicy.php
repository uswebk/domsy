<?php

declare(strict_types=1);

namespace App\Policies;

use App\Infrastructures\Models\Eloquent\DomainDealing;
use App\Infrastructures\Models\Eloquent\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class DomainDealingPolicy
{
    use HandlesAuthorization;


    public function owner(User $user, DomainDealing $domainDealing)
    {
        return $user->id == $domainDealing->domain->user_id && $domainDealing->isUnclaimed();
    }
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Infrastructures\Models\Eloquent\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Infrastructures\Models\Eloquent\User  $user
     * @param  \App\Infrastructures\Models\Eloquent\Domain  $domain
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Domain $domain)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Infrastructures\Models\Eloquent\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Infrastructures\Models\Eloquent\User  $user
     * @param  \App\Infrastructures\Models\Eloquent\Domain  $domain
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Domain $domain)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Infrastructures\Models\Eloquent\User  $user
     * @param  \App\Infrastructures\Models\Eloquent\Domain  $domain
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Domain $domain)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Infrastructures\Models\Eloquent\User  $user
     * @param  \App\Infrastructures\Models\Eloquent\Domain  $domain
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Domain $domain)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Infrastructures\Models\Eloquent\User  $user
     * @param  \App\Infrastructures\Models\Eloquent\Domain  $domain
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Domain $domain)
    {
        //
    }
}
