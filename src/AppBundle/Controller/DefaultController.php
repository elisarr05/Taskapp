<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();

        if(is_null($user)){
            return $this->render('default/index.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
                'role' => ''
            ]);
        }

        $roles = $user->getRoles();
        $role = array_values($roles)[0];
        $tickets = $user->getTickets();

        return $this->render('default/index.html.twig', [
            'user' => $user,
            'tickets' => $tickets,
            'role' => $role
        ]);

    }
}
