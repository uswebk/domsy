<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

final class HasClient implements Rule
{
    private $eloquentClientQueryService;

    /**
     * @param \App\Infrastructures\Queries\Client\EloquentClientQueryServiceInterface $eloquentClientQueryService
     */
    public function __construct(
        \App\Infrastructures\Queries\Client\EloquentClientQueryServiceInterface $eloquentClientQueryService
    ) {
        $this->eloquentClientQueryService = $eloquentClientQueryService;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        try {
            $this->eloquentClientQueryService->firstByIdUserId($value, Auth::id());
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Client does not exist';
    }
}
