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
    public function index(Request $request): Response
    {
        $outingList = $this->getDoctrine()->getRepository(Outing::class)->findAll();
        $campusList = $this->getDoctrine()->getRepository(Campus::class)->findAll();
        $typesList = $this->getDoctrine()->getRepository(Type::class)->findAll();

        $form = $this->createForm(SearchFormType::class, null, [
            'campus_list' => $campusList,
            'types_list' => $typesList
        ]);
        $form->handleRequest($request);

        if ($outingList && $form->isSubmitted() && $form->isValid()) {
            $filters = $form->getData();
            $outingList = $this->applyFilters($filters, $outingList);
        }

        return $this->render('user_home/index.html.twig', [
            'controller_name' => 'UserHomeController',
            'searchForm' => $form->createView(),
            'outingList' => $outingList
        ]);
    }

    private function applyFilters(array $filters, array $outingList): array
    {
        if($filters['campus']) {
            $outingList = $this->filterByCampus($outingList, $filters['campus']);
        }
        if($filters['type']) {
            $outingList = $this->filterByType($outingList, $filters['type']);
        }
        if($filters['keyword']) {
            $outingList = $this->filterByKeyword($outingList, $filters['keyword']);
        }
        if($filters['startDate']) {
            $outingList = $this->filterByStartDate($outingList, $filters['startDate']);
        }
        if($filters['endDate']) {
            $outingList = $this->filterByEndDate($outingList, $filters['endDate']);
        }
        if($filters['isOrganiser']) {
            $outingList = $this->filterByOrganiser($outingList);
        }
        if($filters['participates']) {
            $outingList = $this->filterByParticipates($outingList);
        }
        if($filters['doesntParticipate']) {
            $outingList = $this->filterByDoesntParticipate($outingList);
        }
        if($filters['isFinished']) {
            $outingList = $this->filterByFinished($outingList);
        }
        return $outingList;
    }
    private function filterByCampus(array $outingList, Campus $campus): array
    {
        return array_filter($outingList, function($outing) use ($campus) {
            return $outing->getCampus() === $campus;
        });
    }
    private function filterByType(array $outingList, Type $type): array
    {
        return array_filter($outingList, function($outing) use ($type) {
            return $outing->getType() == $type;
        });
    }
    private function filterByKeyword(array $outingList, string $keyword): array
    {
        return array_filter($outingList, function($outing) use ($keyword) {
            return str_contains($outing->getName(), $keyword);
        });
    }
    private function filterByStartDate(array $outingList, DateTime $startDate): array
    {
        return array_filter($outingList, function($outing) use ($startDate) {
            return $outing->getDayAndTime() > $startDate;
        });
    }
    private function filterByEndDate(array $outingList, DateTime $endDate): array
    {
        return array_filter($outingList, function($outing) use ($endDate) {
            return $outing->getDayAndTime() < $endDate;
        });
    }
    private function filterByOrganiser(array $outingList): array
    {
        return array_filter($outingList, function($outing) {
            return $outing->getOrganiser() == $this->getUser();
        });
    }
    private function filterByParticipates(array $outingList): array
    {
        return array_filter($outingList, function($outing) {
            return in_array($this->getUser(), $outing->getParticipants());
        });
    }
    private function filterByDoesntParticipate(array $outingList): array
    {
        return array_filter($outingList, function($outing) {
            return !in_array($this->getUser(), $outing->getParticipants());
        });
    }
    private function filterByFinished(array $outingList): array
    {
        return array_filter($outingList, function($outing) {
            return $outing->getDayAndTime() < new DateTime();
        });
    }
}
