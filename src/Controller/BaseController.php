<?php

namespace App\Controller;


use App\Service\BaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @var BaseService
     */
    private $service;

    public function __construct(BaseService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route(path="/euro-value", name="getEuroValue", methods={"GET"})
     * @return JsonResponse
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function getEuroValue(): JsonResponse
    {
        return new JsonResponse($this->service->getEuroValue());
    }

    /**
     * @Route(path="/currency/{id}/order/{orderNumber}", name="setOrderNumber", methods={"PUT"})
     * @param int $id
     * @param int $orderNumber
     * @return JsonResponse
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function setOrderNumber(int $id, int $orderNumber): JsonResponse
    {
        $this->service->setOrderNumber($id, $orderNumber);

        return new JsonResponse();
    }

    /**
     * @Route(path="/start", name="startPage", methods={"GET"})
     * @return Response
     */
    public function startPage(): Response
    {
        $html = file_get_contents(dirname(__DIR__, 2)."/index.html");

        return new Response($html);
    }
}