<?php
/**
 * Created by PhpStorm.
 * User: mypc
 * Date: 29/12/17
 * Time: 17:10
 */

namespace App\Controllers;
use App\Services\DependenciesSetService;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class DependenciesSetController
{
    protected $service;
    public function __construct(DependenciesSetService $service)
    {
        return $this->myJsonResponse($this->service = $service);
    }
    public function save(Request $request){
        return $this->myJsonResponse($this->service->save($this->getDataFromResquest($request)));
    }
    public function getDataFromResquest($request){
        return $dependencies =  array(
            "dependency_name" => $request->request->get("dependency_name"),
            "dependency_description" => $request->request->get("dependency_description")
        );
    }
    public function myJsonResponse($data)
    {
        $data = array(
            "status" => 1,
            "data" => $data
        );
        return new JsonResponse($data);
    }
}