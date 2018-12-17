<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;
use AppBundle\Entity\Customer;
use AppBundle\Entity\Part;
use AppBundle\Entity\Sale;
use AppBundle\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends Controller
{
    /**
     * @Route("/customers/all/{order}", name="customers_all", methods={"GET"})
     * @param string $order
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allCustomersAction(string $order)
    {
        $customers = $this
            ->getDoctrine()
            ->getRepository(Customer::class)
            ->findCustomersByBirthDate($order);

        return $this->render("customers/all.html.twig",
            ['customers' => $customers]);
    }

    /**
     * @Route("/customers/{id}", name="customers_one_sale", methods={"GET"})
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCustomerSalesAction(int $id)
    {
        try {
//            $customer= $this
//                ->getDoctrine()
//                ->getRepository(Customer::class)
//                ->findCustomerSales($id);
            /** @var Customer $customer */
            $customer = $this->getDoctrine()
                ->getRepository(Customer::class)
                ->findCustomerSales($id);

            return $this->render("customers/one_sales.html.twig",
                ['customer' => $customer]);
        } catch (\Exception $ex) {
            dump($ex);
            exit();
        }
    }

    /**
     * @Route("/customers/add/new", name="customers_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute('customers_all', array('order' => 'ASC'));
        }

        return $this->render("customers/add.html.twig",
            ['form' => $form->createView()]);
    }

    /**
     * @Route("/customers/edit/{id}", name="customers_edit")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(int $id, Request $request)
    {
        $customer = $this
            ->getDoctrine()
            ->getRepository("AppBundle:Customer")
            ->find($id);
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->merge($customer);
            $em->flush();

            return $this->redirectToRoute('customers_all', array('order' => 'ASC'));
        }

        return $this->render("customers/add.html.twig",
            ['form' => $form->createView()]);
    }

    /**
     * @Route("/customers/delete/{id}", name="customers_delete")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(int $id)
    {
        $customer = $this
            ->getDoctrine()
            ->getRepository("AppBundle:Customer")
            ->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($customer);
        $em->flush();

        return $this->redirectToRoute('customers_all', array('order' => 'ASC'));
    }
}
