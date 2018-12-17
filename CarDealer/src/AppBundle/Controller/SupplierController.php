<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Supplier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class SupplierController extends Controller
{
    /**
     * @Route("/suppliers/{importer}", name="supplier_all", methods={"GET"})
     * @param string $importer
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function allSuppliersAction(string $importer)
    {
        $suppliers= $this
            ->getDoctrine()
            ->getRepository(Supplier::class)
            ->findSuppliersByFilter($importer);

        return $this->render("suppliers/all.html.twig",
            ['suppliers'=>$suppliers, 'typeSupplier'=>$importer]);
    }

    /**
     * @Route("/suppliers/one/{name}", name="supplier_byName", methods={"GET"})
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function getSupplierByName(string $name)
    {
        try{
            $supplier= $this
                ->getDoctrine()
                ->getRepository(Supplier::class)
                ->findSupplierByName($name);

            return $this->render("suppliers/one.html.twig",
                ['supplier'=>$supplier]);
        }catch (\Exception $ex){
            dump($ex);
            exit();
        }
    }
}
