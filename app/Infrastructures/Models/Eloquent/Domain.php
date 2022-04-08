<?php

declare(strict_types=1);

namespace App\Infrastructures\Models\Eloquent;

class Domain extends BaseModel
{
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Infrastructures\Models\Eloquent\User');
    }
}
