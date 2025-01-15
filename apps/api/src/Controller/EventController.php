<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventController extends AbstractController
{
    /**
     * @Route("/event", methods={"POST"})
     */
    public function submitEvent(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $event = new Event($data['id'], $data['name'], json_encode($data['props']));

        // Here you would add logic to store the event in Clickhouse

        return new JsonResponse(['status' => 'Event received'], JsonResponse::HTTP_OK);
    }
} 