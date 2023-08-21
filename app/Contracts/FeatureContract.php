<?php

namespace App\Contracts;

abstract class FeatureContract {
    public BaseTasks $tasks;
    abstract public function handle(BaseTasks $task, array $args = []);
}