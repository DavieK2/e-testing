<?php

namespace App\Modules\UserManager\Models;

use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\SchoolManager\Models\SubjectModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class UserModel extends User
{
    use HasApiTokens, HasFactory, Notifiable, HasUlids;

    protected $primaryKey = 'uuid';

    protected $table = "users";

    protected $guarded = ['uuid'];

    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id');
    }

    public function getIsTeacherAttribute()
    {
        return $this->role->role_name === 'teacher';
    }

    public function getIsQuestionManagerAttribute()
    {
        return $this->role->role_name === 'admin' || $this->role->role_name === 'editor';
    }

    public function getIsAdminAttribute()
    {
        return $this->role->role_name === 'admin';
    }

    public function subjects()
    {
        return $this->belongsToMany(SubjectModel::class, 'user_subjects', 'user_id', 'subject_id');
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'user_classes', 'user_id', 'class_id');
    }

    public function classSubjects()
    {
        return $this->belongsToMany(ClassModel::class, 'user_class_subjects', 'user_id', 'class_id')->withPivot(['subject_id']);
    }

    public function assignToSubject(array $subjects)
    {

       $this->subjects()->detach();

       foreach( $subjects as $subject ){
            DB::table('user_subjects')->insert( ['user_id' => $this->uuid, 'subject_id' => $subject, 'uuid' => Str::ulid() ] );
       }
    }

    public function assignToClassSubjects(array $classSubjects)
    {

       $this->classSubjects()->detach();

       foreach( $classSubjects as $key => $classes ){

          foreach( $classes as $class ){

            DB::table('user_class_subjects')->insert( ['user_id' => $this->uuid, 'class_id' => ClassModel::firstWhere('class_code', $class)->uuid, 'subject_id' => SubjectModel::find($key)->uuid, 'uuid' => Str::ulid() ] );

          }
       }
    }

    public function assignToClass(array $classes)
    {
        $this->classes()->detach();

        foreach( $classes as $class ){
            DB::table('user_classes')->insert( ['user_id' => $this->uuid, 'class_id' => $class, 'uuid' => Str::ulid() ] );
       }
    }

    public function scopeTeachers($query)
    {
        return $query->where( 'role_id', RoleModel::firstWhere('role_name', 'teacher')->uuid );
    }

    public function scopeStudents($query)
    {
        return $query->where( 'role_id', RoleModel::firstWhere('role_name', 'student')->uuid );
    }
}
