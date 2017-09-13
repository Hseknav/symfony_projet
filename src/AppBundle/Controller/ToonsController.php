<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Toon;
use AppBundle\Form\ToonType;
use Symfony\Component\HttpFoundation\Request;

class ToonsController extends Controller
{
    /**
     * @Route("/index", name="index")
     */
    public function indexAction()
    {
        $toons = $this->getDoctrine()->getRepository('AppBundle:Toon')->findAll();

        return $this->render('AppBundle:Toons:index.html.twig', array(
            'toons' => $toons,
        ));
    }

    /**
     * @Route("/add", name="add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $toon = new Toon();

        $form = $this->createForm(ToonType::class,$toon);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // Create user
            $em->persist($toon);
            $em->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('AppBundle:Toons:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
