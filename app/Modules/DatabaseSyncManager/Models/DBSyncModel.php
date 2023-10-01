<?php

namespace App\Modules\DatabaseSyncManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DBSyncModel extends Model
{
    use HasFactory;

    protected $table = 'syncs';

    protected $guarded = ['id'];
}
