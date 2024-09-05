<?php

namespace App\Modules\SchoolManager\Tasks;

use App\Contracts\BaseTasks;
use App\Modules\UserManager\Models\RoleModel;
use App\Modules\UserManager\Models\UserModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeacherTasks extends BaseTasks{

    protected UserModel|null $teacher = null;

    public function assignTeacherToClass() : static
    {
        $this->teacher->assignToClass( $this->item['classes'] );

        return new static( $this->item );
    }

    public function createTeacher() : static
    {
        $user = UserModel::create([
            'uuid'      => Str::ulid(),
            'fullname'  => $this->item['name'],
            'email'     => $this->item['email'],
            'phone_no'  => $this->item['phoneNumber'],
            'password'  => Hash::make($this->item['password'] ?? 'password'),
            'role_id'   => RoleModel::firstWhere('role_name','teacher')->uuid
        ]);

        return new static( [ ...$this->item, 'user' => $user ] );
    }

    public function assignTeacherToSubject() : static
    {
        $this->teacher->assignToSubject( $this->item['subjects'] );

        return new static( $this->item );
    }

    public function classes() : static
    {
        return new static( [ 'query' => $this->teacher->classes() ] );
    }

    public function subjects() : static
    {
        return new static( [ 'query' => $this->teacher->subjects() ] );
    }

    public function getTeachers() : static
    {
        $teachers = UserModel::query()->teachers();

        return new static([ ...$this->item, 'query' => $teachers ]);
    }

    public function teacher( UserModel $teacher ) : static
    {
        if( ! $teacher->exists ) throw new ModelNotFoundException();
        
        $this->teacher = $teacher;

        return $this;
    }

    public function assignClassSubjects() : static
    {
        $this->teacher->assignToClassSubjects( $this->item['classSubjects'] );

        return new static( $this->item );
    }
    
}