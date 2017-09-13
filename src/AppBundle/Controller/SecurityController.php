<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {

        $errors = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('AppBundle:SecurityController:login.html.twig', array(
            'errors' => $errors,
            'lastUsername' => $lastUsername,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        return $this->render('AppBundle:SecurityController:logout.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User();

        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // Create user
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('AppBundle:SecurityController:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
