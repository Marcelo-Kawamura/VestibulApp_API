<?php
/**
 * Created by PhpStorm.
 * User: mypc
 * Date: 27/12/17
 * Time: 22:20
 */

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TopicsController
{
    protected $service;
    public function __construct($service)
    {
        $this->service = $service;
    }

    public function getAll()
    {
        return $this->myJsonResponse($this->service->getAll());
    }
    public function getOne($id)
    {
        return $this->myJsonResponse($this->service->getOne($id));
    }

    public function save(Request $request)
    {
        $data = $this->getDataFromRequest($request);
        return $this->myJsonResponse(array("topic_id" => $this->service->save($data)));
    }
    public function getBySubject($subject_id){
        return $this->myJsonResponse($this->service->getBySubject($subject_id));
    }

    public function getDataFromRequest(Request $request)
    {
        return $topic = array(
            "topic_name" => $request->request->get("topic_name"),
            "subject_id" => $request->request->get("subject_id")
        );
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