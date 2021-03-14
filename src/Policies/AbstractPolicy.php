<?php

namespace Benborla\Hydra\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Benborla\Hydra\Models\Permission;

abstract class AbstractPolicy
{
    use HandlesAuthorization;

    protected $model = '';

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     * @return self
     */
    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @param string $action
     *
     * @return string
     */
    private function roleFromFragments(string $action): string
    {
        return "{$this->getModel()}.$action";
    }

    /**
     * @param \App\Models\User $user
     * @param string $action
     *
     * @return bool
     */
    private function can(User $user, string $action): bool
    {
        return $user->hasPermissionTo($this->roleFromFragments($action));
    }

    /**
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $this->can($user, Permission::CREATE);
    }

    /**
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function update(User $user)
    {
        return $this->can($user, Permission::UPDATE);
    }

    /**
     * delete
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $this->can($user, Permission::DELETE);
    }

    /**
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function view(User $user): bool
    {
        return $this->can($user, Permission::VIEW);
    }

    /**
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function viewAll(User $user): bool
    {
        return $this->can($user, Permission::VIEW_COLLECTION);
    }
}
