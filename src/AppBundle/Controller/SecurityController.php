<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in app/config/security.yml
     *
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        throw new \Exception('This should never be reached!');
    }

    /**
     * @Route("/register", name="register")
     * @Security("has_role('ROLE_NORMAL')")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $role = $request->request->get('appbundle_user')['roles'];

        $logger = $this->get('logger');
        $logger->info('');

        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            if($role == '0'){
                $roles[] = 'ROLE_NORMAL';
            } else if($role == '1'){
                $roles[] = 'ROLE_TECNICO';
            }else{
                $roles[] = 'ROLE_NINGUNO';
            }

            $user->setRoles($roles);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('user_index');
        }


        $userLogueado = $this->getUser();
        $roles = $userLogueado->getRoles();
        $roleLogueado = array_values($roles)[0];
        

        return $this->render('security/register.html.twig', array(
            'form' => $form->createView(),
            'role'  => $roleLogueado,
            'user' => $userLogueado
        ));
        
    }

}
