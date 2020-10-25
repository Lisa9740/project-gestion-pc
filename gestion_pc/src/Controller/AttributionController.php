<?php

namespace App\Controller;

use App\Entity\Atribution;
use App\Entity\Attribution;
use App\Entity\Customer;
use App\Repository\ComputerRepository;
use App\Repository\CustomerRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AttributionController extends AbstractController
{

    /**
     * @Route("/attribution/create", name="attribution_create", methods={"POST"})
     */
    public function addAttribution(Request $request, ComputerRepository $computerRepository, CustomerRepository $customerRepository)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $name = $request->request->get('name');
        $computer = $request->request->get('computer');
        $date = $request->request->get('date');
        $date = DateTime::createFromFormat('d/m/Y', $date);
        $hour = $request->request->get('hour');

        $computer = $computerRepository->find($computer);
        $customer = $customerRepository->findOneBy([ "name" => $name]);

        $attribution = (new Attribution())
            ->setComputer($computer)
            ->setHour((int)$hour)
            ->setDate($date)
            ->setCustomer($customer);


        if (!isset($customer)){
            $customer = (new Customer())
                ->setName($name);
            $attribution
                ->setCustomer($customer);

        }

        $entityManager->persist($attribution);
        $entityManager->flush();

        $this->addFlash('success', $computer->getName() . ' à bien été attribué à ' . $customer->getName() . ' le ' . $attribution->getDate()->format('d/m/Y'));
        return $this->redirectToRoute('date', [ 'date' => $attribution->getDate()->format('d/m/Y') ]);

    }

    /**
     * @Route("/attribution/{id}/delete", name="attribution_delete", methods={"DELETE"})
     */
    public function deleteCustomerAttribution(Attribution $attribution)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($attribution);
        $entityManager->flush();
        return $this->redirectToRoute('date', [ 'date' => $attribution->getDate()->format('d/m/Y') ]);
    }

}
