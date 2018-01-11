<?php
/**
 * Created by PhpStorm.
 * User: mypc
 * Date: 27/12/17
 * Time: 16:29
 */

namespace App\Controllers;

use Mockery\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SubjectsController
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

    public function save(Request $request)
    {
        $subject = $this->getDataFromRequest($request);
        return $this->myJsonResponse(array("subject_id" => $this->service->save($subject)));
    }
    public function getDataFromRequest(Request $request)
    {
        return $subject = array(
            "subject_name" => $request->request->get("subject_name"),
            "subject_photo" => $request->request->get("subject_photo"),
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