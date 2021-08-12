<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Outing;
use App\Entity\OutingImage;
use App\Entity\Type;
use App\Form\OutingFormType;
use App\Form\SearchFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OutingController extends AbstractController
{
    /**
     * @Route("/outing/create", name="outing")
     */
    public function index(Request $request): Response
    {
        $campusList = $this->getDoctrine()->getRepository(Campus::class)->findAll();
        $outing = new Outing();

        $form = $this->createForm(OutingFormType::class, $outing, [
            'campus_list' => $campusList
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $outing->setOrganiser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($outing);

            $image = $form->get('outingImage')->getData();
            $name = $form->get('name')->getData();
            $imageName = preg_replace("/[^a-z]/", '-', strtolower($name));
            $imageFileName = $imageName.'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('outing_img_dir'),
                $imageFileName
            );

            $imageEntity = new OutingImage();
            $imageEntity->setName($imageFileName);
            $outing->setOutingImage($imageEntity);

            $entityManager->persist($outing->getOutingImage());
            $entityManager->flush();

            return $this->redirectToRoute('user_home');
        }

        return $this->render('outing/index.html.twig', [
            'controller_name' => 'OutingController',
            'outingForm' => $form->createView(),
        ]);
    }
    /**
     * @Route("/outing/view/{id}", name="view_outing")
     */
    public function view(Request $request, int $id): Response
    {
        $outing = $this->getDoctrine()->getRepository(Outing::class)->find($id);

        return $this->render('outing/view-outing.html.twig', [
            'controller_name' => 'OutingController',
            'outing' => $outing
        ]);
    }

}
