<?php

namespace App;

use Silex\Application;

class ServicesLoader
{
    protected $app;
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function bindServicesIntoContainer()
    {
        $this->app['dependencies.service'] = function() {
            return new Services\DependenciesSetService($this->app["db"]);
        };
        $this->app['plans.service'] = function() {
            return new Services\PlansService($this->app["db"]);
        };
        $this->app['problems.service'] = function() {
            return new Services\ProblemsService($this->app["db"]);
        };
        $this->app['sessions.service'] = function() {
            return new Services\SessionsService($this->app["db"]);
        };
        $this->app['stackProblems.service'] = function() {
            return new Services\StackProblemsService($this->app["db"]);
        };
        $this->app['subjects.service'] = function() {
            return new Services\SubjectsService($this->app["db"]);
        };
        $this->app['topics.service'] = function() {
            return new Services\TopicsService($this->app["db"]);
        };
        $this->app['users.service'] = function() {
            return new Services\UsersService($this->app["db"]);
        };

    }
}

