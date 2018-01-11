<?php
/**
 * Created by PhpStorm.
 * User: mypc
 * Date: 27/12/17
 * Time: 20:02
 */

namespace App\Controllers;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProblemsController
{
    protected $service;
    public function __construct($service)
    {
        $this->service = $service;
    }
    public function getOne($id)
    {
        return $this->myJsonResponse($this->service->getOne($id));
    }
    public function getAll()
    {
        return $this->myJsonResponse($this->service->getAll());
    }
    public function getAllSet($subject_id, $topic_id, $problem_type_id )
    {
        return $this->myJsonResponse($this->service->getAllSet($subject_id, $topic_id, $problem_type_id ));
    }
    public function save(Request $request)
    {
        $data = $this->getDataFromRequest($request);
        return $this->myJsonResponse(array("problem_id" => $this->service->save($data)));
    }

    public function getDataFromRequest(Request $request)
    {
            // problem root
        $problem_type = $request->request->get("problem_type");
        $problem = array(
            "problem_name" => $request->request->get("problem_name"),
            "problem_difficulty" => $request->request->get("problem_difficulty"),
            "problem_type" => $problem_type,
            "topic_topic_id" => $request->request->get("topic_id"),
            "dependency_set_dependency_id" => $request->request->get("dependency_id")
            //problem_type_id is create by insert
        );
            //problems children
        switch ($problem_type){
            case 0: //check problems
                $check = array(
                    "check_description" => $request->request->get("check_description"),
                    "item" => $request->request->get("item"),
                    //check_check_id is create by insert
                );
                return array_merge($problem,$check);
                break;
            case 1: // drag and drop problems
                $drag_drop = array(
                    "drag_drop_description" => $request->request->get("drag_drop_description"),
                    "drag_description" => $request->request->get("drag_description"),
                    "drop_description" => $request->request->get("drop_description")
                    //all ids are create by insert
                );
                return array_merge($problem,$drag_drop);
                break;
        }

    }

    public function myJsonResponse($dataJson)
    {
        $data = array(
            "status" => 1,
            "data" => $dataJson
        );
        return new JsonResponse($data);
    }
}