<?php

namespace App\Controller\Management;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use App\Util\GuidGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/room')]
#[IsGranted('ROLE_MODERATOR')]
class RoomController extends AbstractController
{
    #[Route('/', name: 'app_room_index', methods: ['GET','POST'])]
    public function index(
        RoomRepository $roomRepository,
        Request $request,
    ): Response {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $room->setGuid(GuidGenerator::generate());
            $roomRepository->save($room, true);

            return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('room/index.html.twig', [
            'room' => $room,
            'form' => $form,
            'rooms' => $roomRepository->findAll(),
        ]);
    }


    #[Route('/{id}/edit', name: 'app_room_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Room $room, RoomRepository $roomRepository): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roomRepository->save($room, true);

            return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('room/index.html.twig', [
            'room' => $room,
            'form' => $form,
            'rooms' => $roomRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_room_delete', methods: ['GET'])]
    public function delete(Room $room, RoomRepository $roomRepository): Response
    {
        $roomRepository->remove($room, true);

        return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
    }
}
