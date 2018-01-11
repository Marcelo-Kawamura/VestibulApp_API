<?php
/**
 * Created by PhpStorm.
 * User: mypc
 * Date: 27/12/17
 * Time: 13:35
 */

namespace App\Controllers;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlansController
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
        $data = $this->getDataFromRequest($request);
        return $this->myJsonResponse(array("plan_id" => $this->service->save($data)));
    }

    public function update($id, Request $request)
    {
        $plan = $this->getDataFromRequest($request);
        $this->service->update($id, $plan);
        return $this->myJsonResponse($plan);
    }

    public function delete($id)
    {
        return $this->myJsonResponse($this->service->delete($id));
    }

    public function getDataFromRequest(Request $request)
    {

        return $plan = array(
                "plan_id" => $request->request->get("plan_id"),
                "plan_price" => $request->request->get("plan_price"),
                "plan_name" => $request->request->get("plan_name"),
                "plan_description" => $request->request->get("plan_description"),
                "plan_duration" => $request->request->get("plan_duration")
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