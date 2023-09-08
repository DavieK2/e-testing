<?php

namespace App\Modules\UserManager\Models;

use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\SchoolManager\Models\SubjectModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends User
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";

    protected $guarded = ['id'];

    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(SubjectModel::class, 'user_subjects', 'user_id', 'subject_id');
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'user_classes', 'user_id', 'class_id');
    }

    public function assignToSubject(array $subjects)
    {
        return $this->subjects()->sync($subjects);
    }

    public function assignToClass(array $classes)
    {
        return $this->classes()->sync($classes);
    }

    public function scopeTeachers($query)
    {
        return $query->where( 'role_id', RoleModel::firstWhere('role_name', 'teacher')->id );
    }

    public function scopeStudents($query)
    {
        return $query->where( 'role_id', RoleModel::firstWhere('role_name', 'student')->id );
    }
}
