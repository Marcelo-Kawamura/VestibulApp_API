<?php
/**
 * Created by PhpStorm.
 * User: mypc
 * Date: 28/12/17
 * Time: 14:16
 */

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Services;

class UsersController
{
    protected  $service;
    public function __construct(Services\UsersService $service)
    {
        $this->service = $service;
    }
    public function save(Request $request)
    {
        $data = $this->getDataFromRequestUserSave($request);
        $this->service->save($data);
        return $this->myJsonResponse(array("student_token" => $data["student_token"]));
    }
    public function getDataFromRequestUserSave(Request $request)
    {
        return $data = array(
            "student_cpf" => $request->request->get("student_cpf"),
            "student_name" => $request->request->get("student_name"),
            "student_last_name" => $request->request->get("student_last_name"),
            "student_email" => $request->request->get("student_email"),
            "student_password" => $request->request->get("student_password"),
            "student_token" => md5($request->request->get("student_cpf").date('m/d/Y h:i:s a', time()))
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
    public function myJsonResponseFail()
    {
        $data = array(
            "status" => 0,
            "data" => null
        );
        return new JsonResponse($data);
    }
}