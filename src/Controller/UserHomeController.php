<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Outing;
use App\Entity\Type;
use App\Form\SearchFormType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserHomeController extends AbstractController
{
    #[Route('/user/home', name: 'user_home')]
    public function index(): Response
    {
        $outingList = $this->getDoctrine()->getRepository(Outing::class)->findAll();
        $campusList = $this->getDoctrine()->getRepository(Campus::class)->findAll();
        $typesList = $this->getDoctrine()->getRepository(Type::class)->findAll();

        $form = $this->createForm(SearchFormType::class, null, [
            'method' => 'GET',
            'campus_list' => $campusList,
            'types_list' => $typesList
        ]);

        return $this->render('user_home/index.html.twig', [
            'controller_name' => 'UserHomeController',
            'searchForm' => $form->createView(),
            'outingList' => $outingList
        ]);
    }

    #[Route('/user/home?{query}', name: 'search_home')]
    public function filter(Request $request): Response
    {
        $outingList = $this->getDoctrine()->getRepository(Outing::class)->findAll();
        $campusList = $this->getDoctrine()->getRepository(Campus::class)->findAll();
        $typesList = $this->getDoctrine()->getRepository(Type::class)->findAll();

        $form = $this->createForm(SearchFormType::class, null, [
            'method' => 'GET',
            'campus_list' => $campusList,
            'types_list' => $typesList
        ]);
        $form->handleRequest($request);

        if ($outingList && $form->isSubmitted() && $form->isValid()) {
            $filters = $form->getData();
            $this->applyFilters($filters, $outingList);
        }

        return $this->render('user_home/index.html.twig', [
            'controller_name' => 'UserHomeController',
            'searchForm' => $form->createView(),
            'outingList' => $outingList
        ]);
    }
    private function applyFilters(array $filters, array $outingList) {
        if($filters['campus']) {
            $this->filterByCampus($outingList, $filters['campus']);
        }
        if($filters['type']) {
            $this->filterByType($outingList, $filters['type']);
        }
        if($filters['keyword']) {
            $this->filterByKeyword($outingList, $filters['keyword']);
        }
        if($filters['startDate']) {
            $this->filterByStartDate($outingList, $filters['startDate']);
        }
        if($filters['endDate']) {
            $this->filterByEndDate($outingList, $filters['endDate']);
        }
        if($filters['isOrganiser']) {
            $this->filterByOrganiser($outingList);
        }
        if($filters['participates']) {
            $this->filterByParticipates($outingList);
        }
        if($filters['doesntParticipate']) {
            $this->filterByDoesntParticipate($outingList);
        }
        if($filters['isFinished']) {
            $this->filterByFinished($outingList);
        }
    }
    private function filterByCampus(array $outingList, int $campusId)
    {
        array_filter($outingList, function($outing) use ($campusId) {
            $outing->getCampus()->getId() === $campusId;
        });
    }
    private function filterByType(array $outingList, int $typeId)
    {
        array_filter($outingList, function($outing) use ($typeId) {
            $outing->getType()->getId() === $typeId;
        });
    }
    private function filterByKeyword(array $outingList, string $keyword)
    {
        array_filter($outingList, function($outing) use ($keyword) {
            str_contains($outing->getName(), $keyword);
        });
    }
    private function filterByStartDate(array $outingList, DateTime $startDate)
    {
        array_filter($outingList, function($outing) use ($startDate) {
            $outing->getDayAndTime() > $startDate;
        });
    }
    private function filterByEndDate(array $outingList, DateTime $endDate)
    {
        array_filter($outingList, function($outing) use ($endDate) {
            $outing->getDayAndTime() < $endDate;
        });
    }
    private function filterByOrganiser(array $outingList)
    {
        array_filter($outingList, function($outing) {
            $outing->getOrganiser() === $this->getUser();
        });
    }
    private function filterByParticipates(array $outingList)
    {
        array_filter($outingList, function($outing) {
            in_array($this->getUser(), $outing->getParticipants());
        });
    }
    private function filterByDoesntParticipate(array $outingList)
    {
        array_filter($outingList, function($outing) {
            !in_array($this->getUser(), $outing->getParticipants());
        });
    }
    private function filterByFinished(array $outingList)
    {
        array_filter($outingList, function($outing) {
            $outing->getDayAndTime() > new DateTime();
        });
    }
}
