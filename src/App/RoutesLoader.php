<?php

namespace App;

use Silex\Application;

class RoutesLoader
{
    private $app;
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->instantiateControllers();
    }
    private function instantiateControllers()
    {
        $this->app['dependencies.controller'] = function() {
            return new Controllers\DependenciesSetController($this->app['dependencies.service']);
        };
        $this->app['plans.controller'] = function() {
            return new Controllers\PlansController($this->app['plans.service']);
        };
        $this->app['problems.controller'] = function() {
            return new Controllers\ProblemsController($this->app['problems.service']);
        };
        $this->app['resume.controller'] = function() {
            return new Controllers\ResumesController($this->app['resume.service']);
        };
        $this->app['sessions.controller'] = function() {
            return new Controllers\SessionsController($this->app['sessions.service']);
        };
        $this->app['subjects.controller'] = function() {
            return new Controllers\SubjectsController($this->app['subjects.service']);
        };
        $this->app['topics.controller'] = function() {
            return new Controllers\TopicsController($this->app['topics.service']);
        };
        $this->app['users.controller'] = function() {
            return new Controllers\UsersController($this->app['users.service']);
        };
        $this->app['stackProblems.controller'] = function() {
            return new Controllers\StackProblemsController($this->app['stackProblems.service']);
        };

    }

    public function bindRoutesToControllers()
    {
        $api = $this->app["controllers_factory"];

        $api->post('/dependencies', "dependencies.controller:save");

        $api->get('/plans', "plans.controller:getAll");
        $api->get('/plans/{id}', "plans.controller:getOne");
        $api->post('/plans', "plans.controller:save");
        $api->put('/plans/{id}', "plans.controller:update");
        $api->delete('/plans/{id}', "plans.controller:delete");

        $api->get('/problems', "problems.controller:getAll");
        $api->get('/problems/{id}', "problems.controller:getOne");
        $api->get('/problems/subject/{subject_id}/topic/{topic_id}/type/{problem_type_id}', "problems.controller:getAllSet");
        $api->post('/problems', "problems.controller:save");

        $api->post('/resumes/{id}', "resume.controller:save");

        $api->post('/sessions', "sessions.controller:signIn");
        $api->post('/sessions/{id}', "sessions.controller:signOut");

        $api->get('/stackproblems/{id}', "stackProblems.controller:getOne");
        $api->post('/stackproblems/initialize', "stackProblems.controller:initialize");
        $api->post('/stackproblems/getnextfromstack', "stackProblems.controller:getNextFromStack");

        $api->get('/stackproblems/user/{user_id}', "stackProblems.controller:getByUser");
        $api->get('/stackproblems/user/{user_id}/subject/{subject_id}', "stackProblems.controller:getBySubject");
        $api->get('/stackproblems/user/{user_id}/subject/{subject_id}/topic/{topic_id}', "stackProblems.controller:getByTopic");
        $api->post('/stackproblems/{id}', "stackProblems.controller:processAnswer");
        $api->post('/stackproblems', "stackProblems.controller:processAnswer2");
       # $api->post('/stackproblems', "stackProblems.controller:save");

        $api->get('/subjects', "subjects.controller:getAll");
        $api->post('/subjects', "subjects.controller:save");

        $api->get('/topics/{id}', "topics.controller:getOne");
        $api->get('/topics', "topics.controller:getAll");
        $api->get('/topics/subject/{subject_id}', "topics.controller:getBySubject");
        $api->post('/topics', "topics.controller:save");

        $api->post('/users', "users.controller:save");


        $this->app->mount($this->app["api.endpoint"].'/'.$this->app["api.version"], $api);
    }
}

