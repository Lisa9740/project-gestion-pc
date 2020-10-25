<?php

namespace App\Controller;

use App\Entity\Attribution;
use App\Entity\Computer;
use App\Form\ComputerType;
use App\Repository\AttributionRepository;
use App\Repository\ComputerRepository;
use App\Repository\CustomerRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComputerController extends AbstractController
{
    /**
     * @Route("/computer", name="computer_index", methods={"GET"})
     * @param ComputerRepository $repo
     * @return Response
     */
    public function indexComputer(RequestStack $requestStack, ComputerRepository $repo, AttributionRepository $attributionRepository, CustomerRepository $customerRepository)
    {
        $computer = $repo->findAll();
        $customer = $customerRepository->findAll();
        $request = $requestStack->getCurrentRequest();

        $forms = [];
        foreach ($computer as $index){
            $forms[$index->getId()] = $this->container
                ->get('form.factory')
                ->createNamed('forms' . $index->getId(), ComputerType::class, $index);
        }

        foreach ($forms as &$form)
        {
            $form = $form->createView();
        }


        $attributions = $attributionRepository->findAll();

        return $this->render('computer/index.html.twig', [
            'forms'  => $forms,
            'customers' => $customer,
            'computers' => $computer,
            "date" => $request->attributes->get('date'),
            'attributions' => $attributions,
        ]);
    }


    /**
     * @Route("/computer/new", name="computer_create", methods={"POST"})
     */
    public function createComputer(Request $request) : Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $name = $request->request->get('name');
        $date = $request->request->get('date');
        $date = DateTime::createFromFormat('d/m/Y', $date);
        $computer = (new Computer())
            ->setName($name);

        for ( $i=8; $i<19; $i++){
            $attribution = (new Attribution())
                ->setHour($i)
                ->setDate($date)
                ->setComputer($computer);
            $entityManager->persist($attribution);
        }

        $entityManager->persist($computer);
        $entityManager->flush();

        $this->addFlash('success', $computer->getName() . ' à bien été ajouté.');
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/computer/{id}/edit", name="computer_edit", methods={"POST"})
     */
    public function editComputer(RequestStack $requestStack, Computer $computer) : Response
    {
        $request = $requestStack->getCurrentRequest();

        $name = $request->request->get('forms' . $computer->getId())['name'];
        $computer->setName($name);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($computer);
        $entityManager->flush();

        $this->addFlash('success', $computer->getName() . ' à bien été ajouté.');
        return $this->redirectToRoute('home');

    }

    /**
     * @Route("/computer/{id}/delete", name="computer_delete", methods={"DELETE"})
     */
    public function deleteComputer(Computer $computer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $attributions = $computer->getAttributions();

        foreach ($attributions as $attribution){
            $computer->removeAttribution($attribution);
        }

        $entityManager->remove($computer);
        $entityManager->flush();
        $this->addFlash('success', $computer->getName() . ' à bien été supprimé.');
        return $this->redirectToRoute('home');
    }

}
