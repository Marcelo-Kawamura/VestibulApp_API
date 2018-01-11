<?php
/**
 * Created by PhpStorm.
 * User: mypc
 * Date: 27/12/17
 * Time: 16:47
 */

namespace App\Controllers;
use App\Services\SessionsService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SessionsController
{
    protected  $service;
    public function __construct(SessionsService $service)
    {
        $this->service = $service;
    }
    public function signOut($id){
        $this->service->signOut($id);
        return $this->myJsonResponse("signOut");
    }
    public function signIn(Request $request){
        $data = $this->getDataFromRequestSignIn($request);
        //verify user credentials
        if($student_data = $this->service->signIn($data)['student_email']!=null)
        {
            //update token if credentials are true
            return  $this->myJsonResponse(array(
                    'student_token' => $this->service->tokenUpdate($student_data))
            );

        }else{
            return $this->myJsonResponseFail();
        }

    }
    public function getDataFromRequestSignIn(Request $request)
    {
        return $data = array(
            "student_email" => $request->request->get("student_email"),
            "student_password" => $request->request->get("student_password")
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