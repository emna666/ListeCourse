<?php

namespace RestBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use RestBundle\Entity\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("api")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/login", defaults={"_format" = "json"}, name="api_login")
     * @Method("post")
     * @ApiDoc(
     *   parameters={
     *     {"name"="login","dataType"="string","required"=true},
     *     {"name"="password","dataType"="string","required"=true},
     *     {"name"="deviceId","dataType"="string","required"=true},
     *     {"name"="deviceType","dataType"="string","required"=true}
     *   }
     * )
     */
    public function loginAction(Request $request)
    {
        $login = $request->get("login");
        $password = $request->get("password");
        $deviceId = $request->get("deviceId");
        $deviceType = $request->get("deviceType");
        $verifParameters = $this->get('rest.service')->verifEmpty(array('login', 'password', 'deviceId', 'deviceType'));
        if ($verifParameters instanceof JsonResponse)
            return $verifParameters;
        $user = $this->get('rest.session.service')->getUserByUsername($login);
        if ($user instanceof JsonResponse)
            return $user;
        if ($this->get('rest.session.service')->isValidPassword($user, $password))
        {
            $session = $this->get('rest.session.service')->newSession($user, $deviceId, $deviceType);
            return $this->get('rest.service')->successResponse(array('session' => $session));
        } else
            return $this->get('rest.service')->errorResponse("Invalide login  ou mot de passe");
    }

    /**
     * @Route("/supermarches", defaults={"_format" = "json"}, name="api_supermarches")
     * @Method("get")
     * @ApiDoc(
     *   parameters={
     *     {"name"="token","dataType"="string","required"=true}
     *   }
     * )
     */
    public function supermarchesAction(Request $request)
    {
        $session = $this->get('rest.session.service')->getSessionByToken();
        if ($session instanceof JsonResponse)
            return $session;
        elseif ($session instanceof Session)
        {
            return $this->get('rest.data.service')->getSupermarches();
        }
    }

    /**
     * @Route("/produitsBySupermarche", defaults={"_format" = "json"}, name="api__produit_supermarches")
     * @Method("get")
     * @ApiDoc(
     *   parameters={
     *     {"name"="token","dataType"="string","required"=true},
     *     {"name"="idSupermarche","dataType"="string","required"=true}
     *   }
     * )
     */
    public function produitsAction(Request $request)
    {
        $idSupermarche = $request->get("idSupermarche");
        $verifParameters = $this->get('rest.service')->verifEmpty(array('idSupermarche'));
        if ($verifParameters instanceof JsonResponse)
            return $verifParameters;
        $session = $this->get('rest.session.service')->getSessionByToken();
        if ($session instanceof JsonResponse)
            return $session;
        elseif ($session instanceof Session)
        {
            return $this->get('rest.data.service')->getProduits($idSupermarche);
        }
    }
}