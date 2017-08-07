<?php

namespace RestBundle\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class RestService
{

    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request->getCurrentRequest();
    }



    public function verifEmpty($args = array())
    {
        foreach ($args as $arg)
        {
            $val = $this->request->get($arg);
            if (empty($val))
                return $this->errorResponse("Invalide parameter $arg");
            if ($arg == "deviceType" and $val != "ANDROID" and $val != "IOS")
                return $this->errorResponse("deviceType doit etre soit ANDROID ou IOS");
        }
    }

    public function errorResponse($msg)
    {
        return new JsonResponse(
            array(
                'code'    => 400,
                'message' => $msg
            )
        );
    }

    public function successResponse($data)
    {
        return new JsonResponse(
            array(
                'code' => 200,
                'data' => $data
            )
        );
    }

    public function successMessage($msg)
    {
        return new JsonResponse(
            array(
                'code'    => 200,
                'message' => $msg,
            )
        );
    }
}