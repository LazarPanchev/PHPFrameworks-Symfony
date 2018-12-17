<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sale;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class SaleController extends Controller
{
    /**
     * @Route("/sales", name="sales_all", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allSalesAction()
    {
        $sales = $this
            ->getDoctrine()
            ->getRepository(Sale::class)
            ->findAllSales();

        return $this->render("sales/all.html.twig",
            ['sales' => $sales]);
    }

    /**
     * @Route("/sales/one/{id}", name="sales_details", methods={"GET"})
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailsSaleAction($id)
    {
        try {
            $sale = $this
                ->getDoctrine()
                ->getRepository(Sale::class)
                ->findDetailsSale($id);

            return $this->render("sales/details.html.twig",
                ['sale' => $sale]);
        } catch (\Exception $ex) {
            dump($ex);
            exit();
        }

    }

    /**
     * @Route("/sales/discounted", name="sales_discounted", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getDiscountedAction()
    {
        $sales = $this
            ->getDoctrine()
            ->getRepository(Sale::class)
            ->findDiscounted();

        return $this->render("sales/discounted.html.twig",
            ['sales' => $sales]);
    }

    /**
     * @Route("/sales/discounted/{percent}", name="sales_discounted_percent", methods={"GET"})
     * @param string $percent
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getDiscountOneAction(string $percent)
    {
            $sales = $this
                ->getDoctrine()
                ->getRepository(Sale::class)
                ->findDiscountedPercent($percent);

            return $this->render("sales/discounted.html.twig",
                ['sales' => $sales]);
    }
}
