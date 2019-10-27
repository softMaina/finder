<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends \Spatie\Permission\Models\Role
{
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function users(): MorphToMany
    {
        return $this->belongsToMany('App\User', 'model_has_roles', 'role_id', 'model_id');
    }
}
