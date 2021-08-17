<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Outing;
use App\Entity\OutingImage;
use App\Entity\Type;
use App\Form\ImageFormType;
use App\Form\OutingFormType;
use App\Form\SearchFormType;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OutingController extends AbstractController
{
    /**
     * @Route("/outing/create", name="create_outing")
     */
    public function create(Request $request): Response
    {
        $campusList = $this->getDoctrine()->getRepository(Campus::class)->findAll();
        $outing = new Outing();

        $form = $this->createForm(OutingFormType::class, $outing, [
            'campus_list' => $campusList
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Setting organiser
            $outing->setOrganiser($this->getUser());

            // Persisting outing entity first -> its id is generated
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($outing);

            // Uploading the file to the right directory, with a clean name
            $imageUploader = new ImageUploader($this->getParameter('outing_img_dir'));
            $name = $form->get('name')->getData();
            $imageFileName = $imageUploader->upload($form->get('outingImage')->getData(), $name);

            // Saving new image's name in db table
            if($imageFileName) {
                $imageEntity = new OutingImage();
                $imageEntity->setName($imageFileName);
                $outing->setOutingImage($imageEntity);
                $entityManager->persist($outing->getOutingImage());
            }
            $entityManager->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('outing/form.html.twig', [
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

        return $this->render('outing/view.html.twig', [
            'controller_name' => 'OutingController',
            'outing' => $outing
        ]);
    }

    /**
     * @Route("/outing/edit/{id}", name="edit_outing")
     */
    public function edit(Request $request, int $id): Response
    {
        $campusList = $this->getDoctrine()->getRepository(Campus::class)->findAll();
        $outing = $this->getDoctrine()->getRepository(Outing::class)->find($id);

        $form = $this->createForm(OutingFormType::class, $outing, [
            'campus_list' => $campusList
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Persisting outing entity
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($outing);
            $entityManager->flush();

            return $this->redirectToRoute('view_outing', ['id' => $id]);
        }

        return $this->render('outing/form.html.twig', [
            'controller_name' => 'OutingController',
            'outingForm' => $form->createView(),
            'outing' => $outing
        ]);
    }

    /**
     * @Route("/outing/edit/{id}/image", name="edit_outing_image")
     */
    public function editImage(Request $request, int $id): Response
    {
        $form = $this->createForm(ImageFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Getting the outing's name
            $outing = $this->getDoctrine()->getRepository(Outing::class)->find($id);
            $name = $outing->getName();

            // Uploading the file to the right directory, with a clean name
            $imageUploader = new ImageUploader($this->getParameter('outing_img_dir'));
            $imageFileName = $imageUploader->upload($form->get('image')->getData(), $name);


            if($imageFileName) {
                // Saving new image's name in db table
                $imageEntity = new OutingImage();
                $entityManager = $this->getDoctrine()->getManager();
                $imageEntity->setName($imageFileName);
                $outing->setOutingImage($imageEntity);
                $entityManager->persist($outing->getOutingImage());
                $entityManager->flush();
            } else {
                //TODO: Handle upload error
            }

            return $this->redirectToRoute('view_outing', ['id' => $id]);
        }

        return $this->render('image/edit.html.twig', [
            'controller_name' => 'OutingController',
            'imageForm' => $form->createView(),
        ]);
    }
    /**
     * @Route("/outing/{id}/register", name="register")
     */
    public function register(Request $request, int $id): Response
    {
        $outing = $this->getDoctrine()->getRepository(Outing::class)->find($id);
        $outing->addParticipant($this->getUser());

        // Persisting the change
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($outing);
        $entityManager->flush();

        return $this->redirectToRoute('view_outing', ['id' => $id]);

    }

    /**
     * @Route("/outing/{id}/unregister", name="unregister")
     */
    public function unregister(Request $request, int $id): Response
    {
        $outing = $this->getDoctrine()->getRepository(Outing::class)->find($id);
        $outing->removeParticipant($this->getUser());

        // Persisting the change
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($outing);
        $entityManager->flush();

        return $this->redirectToRoute('view_outing', ['id' => $id]);

    }

    /**
     * @Route("/outing/delete/{id}", name="delete_outing")
     */
    public function delete(Request $request, int $id): Response
    {
        $outing = $this->getDoctrine()->getRepository(Outing::class)->find($id);
        if($outing->getOrganizer()->getId() === $this->getUser()->getId()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($outing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dashboard');
    }

}
