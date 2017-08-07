<?php

namespace RestBundle\Service;

use back\GeneralBundle\Entity\User;
use RestBundle\Entity\Session;
use RestBundle\Service\RestService;
use Doctrine\ORM\EntityManager;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class RestSessionService
{

    public function __construct(Serializer $serializer, EntityManager $em, RestService $restService, RestDataService $restDataService, RequestStack $requestStack, EncoderFactory $encoderFactory)
    {
        $this->serializer = $serializer;
        $this->em = $em;
        $this->restService = $restService;
        $this->dataService = $restDataService;
        $this->request = $requestStack->getCurrentRequest();
        $this->requestStack = $requestStack;
        $this->encoderFactory = $encoderFactory;
    }

    public function generateToken()
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);
        $token = '';
        $counter = 0;
        while ($counter < 10)
        {
            $index = rand(0, $count - 1);
            $token .= mb_substr($chars, $index, 1);
            $counter++;
        }
        return $token;
    }

    public function newSession(User $user, $deviceId, $deviceType)
    {
        $this->em->getRepository(Session::class)->deleteOldSession($user);
        $session = new Session();
        $session
            ->setUser($user)
            ->setToken($this->generateToken())
            ->setDeviceId($deviceId)
            ->setDeviceType($deviceType);
        $this->em->persist($session);
        $this->em->flush();
        return $this->dataService->toArray($session);
    }

    public function getUserByUsername($username)
    {
        $user = $this->em->getRepository(User::class)->findOneBy(array("username" => $username));
        if (!$user)
            return $this->restService->errorResponse("Invalid login or password");
        if (!$user->isAccountNonLocked())
            return $this->restService->errorResponse("Locked Account");
        if (!$user->isEnabled())
            return $this->restService->errorResponse("Account disabled");
        /*if (!$user->hasRole("ROLE_USER"))
            return $this->restService->errorResponse("This account is not a crew member");*/
        return $user;
    }

    public function isValidPassword(User $user, $password)
    {
        $factory = $this->encoderFactory;
        $encoder = $factory->getEncoder($user);
        return $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
    }


    public function getSessionByToken()
    {
        if ($this->request->get("token"))
        {
            $token = $this->request->get("token");
            $session = $this->em->getRepository(Session::class)->findOneBy(array('token' => $token));
            if ($session)
                return $session;
            else
                return $this->restService->errorResponse("Unknown token");
        }
        return $this->restService->errorResponse("Empty token");
    }

    public function logout()
    {
        $session = $this->getSessionByToken();
        if ($session instanceof JsonResponse)
            return $session;
        elseif ($session instanceof Session)
        {
            try
            {
                $this->deleteSession($session);
                return $this->restService->successResponse("Token Deleted");
            } catch (\Exception $ex)
            {
                $this->restService->errorResponse($ex->getMessage());
            }
        }
    }

    public function deleteSession(Session $session)
    {
        $this->em->remove($session);
        $this->em->flush();
    }

    public function objectToArray($object)
    {
        if ($object)
            return $this->serializer->toArray($object);
        return null;
    }
}