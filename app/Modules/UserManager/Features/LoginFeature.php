<?php

namespace App\Modules\UserManager\Features;

use App\Contracts\BaseTasks;
use App\Contracts\FeatureContract;
use App\Contracts\ResponseType;
use App\Modules\UserManager\Constants\UserManagerConstants;
use App\Modules\UserManager\Tasks\LoginTasks;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class LoginFeature extends FeatureContract {

    public function __construct(){
        $this->tasks = new LoginTasks();
    }
    
    public function handle(BaseTasks $task, array $args = [])
    {
        try {

            $builder = $task->start($args)->checkIfUserExists()->login();

            return $task::formatResponse($builder->only(['token', 'url']), ResponseType::JSON, ['message' => "Login Successful"] );

        } catch (ValidationException $exception) {

            throw $exception;

        } catch (ModelNotFoundException $exception){

            throw ValidationException::withMessages(['user' => 'User Not Found']);
        }
      
    }
}