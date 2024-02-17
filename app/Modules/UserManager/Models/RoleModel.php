<?php

namespace App\Modules\UserManager\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'uuid';
    
    protected $table = "roles";

    protected $guarded = ['uuid'];

    public function users()
    {
        return $this->hasMany(UserModel::class, 'role_id');
    }
}
