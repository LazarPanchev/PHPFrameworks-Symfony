<?php

namespace AppBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends Controller
{
    /**
     * @var ArrayCollection
     */
    private $items;                //for the example, instate of Database

    public function __construct()
    {
        $this->items=[
            1=>['shoes'=>'boots', 'socket'=>'long'],
            2=>['jacket'=>'coat', 'pants'=>'skirt'],
            3=>['hat'=>'basketball hat', 'hair'=> 'dark hair']
        ];
    }

    /**
     * @Route("/items", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAllItemsAction()
    {
        return $this->json($this->items);
    }


    /**
     * @Route("/items/{id}", methods={"GET"})
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getOneItemAction(int $id)
    {
        return $this->json($this->items[$id]);
    }


    /**
     * @Route("/items", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createItemAction(Request $request)
    {
        //get body- with the data
        $newItem=json_decode($request->getContent());
        $this->items[]=$newItem;
        return $this->json($this->items);
    }


    /**
     * @Route("/items/{id}", methods={"PUT"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editItemAction(int $id, Request $request)
    {

        $updatedItem=json_decode($request->getContent());
        $this->items[$id]=$updatedItem;
        return $this->json($this->items);
    }


    /**
     * @Route("/items/{id}",methods={"DELETE"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteItemAction(int $id)
    {
        unset($this->items[$id]);
        return $this->json($this->items);
    }
}
