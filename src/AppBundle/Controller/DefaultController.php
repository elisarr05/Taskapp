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
            ]);
        }
        $roles = $user->getRoles();
        $role = array_values($roles)[0];

        if($role == 'ROLE_NORMAL'){
            return $this->render('default/indexNormal.html.twig', [
                'user' => $user
            ]);
        }elseif ($role == 'ROLE_TECNICO'){
            return $this->render('default/indexTecnico.html.twig', [
                'user' => $user
            ]);
        }

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
