<?php

namespace App\Models;

use App\WithBuilder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as PermissionModel;

class Permission extends PermissionModel
{
    use WithBuilder;

    protected $table = 'permissions';

    protected $guarded = ['id'];
}
