<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Outing;
use App\Entity\Type;
use App\Form\SearchFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
