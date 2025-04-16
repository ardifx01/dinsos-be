<?php

namespace App\Models;

use App\WithBuilder;
use Spatie\Permission\Models\Role as RoleModel;

class Role extends RoleModel
{
    use WithBuilder;

    protected $table = 'roles';

    protected $guarded = ['id'];
}
