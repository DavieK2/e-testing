<?php

namespace App\Modules\UserManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Modules\UserManager\Tasks\LoginTasks;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class LoginFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new LoginTasks();
    }
    
    public function handle(BaseTasks|LoginTasks $task, array $args = [])
    {
        try {

            return $task->withParameters($args)
                        ->checkIfUserExists()
                        ->login()
                        ->only(['token', 'url'])
                        ->formatResponse(
                            options: ['message' => "Login Successful"] 
                        );

        } catch (ValidationException $exception) {

            throw $exception;

        } catch (ModelNotFoundException $exception){

            throw ValidationException::withMessages(['user' => 'User Not Found']);
        }
      
    }
}