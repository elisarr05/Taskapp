<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Nota;
use AppBundle\Entity\Ticket;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Ticket controller.
 *
 * @Route("ticket")
 */
class TicketController extends Controller
{
    /**
     * Lists all ticket entities.
     *
     * @Route("/", name="ticket_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        if(is_null($user)){
            return $this->redirectToRoute('homepage');
        }
        $tickets = $user->getUsuarioTickets();
        $roles = $user->getRoles();
        $role = array_values($roles)[0];
        return $this->render('ticket/index.html.twig', array(
            'tickets' => $tickets,
            'role' => $role,
            'user' => $user
        ));
    }

    /**
     * Creates a new nota.
     * @Route("/agregarNota", name="agregar_nota")
     */
    public function agregarNotaAction(Request $request)
    {
        $notaMensaje = $request->get('nota');
        $ticketId = $request->get('ticketId');

        $emTicket = $this->getDoctrine()->getManager()->getRepository('AppBundle:Ticket');
        $ticket = $emTicket->find($ticketId);

        $user = $this->getUser();

        $nota = new Nota();
        $nota->setNota($notaMensaje);
        $nota->setTicket($ticket);
        $nota->setFecha(new \DateTime());
        $nota->setUsuario($user);

        $emNota = $this->getDoctrine()->getManager();
        $emNota->persist($nota);
        $emNota->flush();

        return $this->redirectToRoute('ticket_show', array('id' => $ticketId));
    }

    /**
     * Finds and displays a ticket entity.
     *
     * @Route("/{id}/cambiarEstado/", name="ticket_cambiar_estado")
     * @Method("GET")
     */
    public function cambiarEstadoAction(Ticket $ticket)
    {

        if($ticket->getEstado() == 'Pendiente'){
            $ticket->setEstado('En_proceso');
        }elseif ($ticket->getEstado() == 'En_proceso'){
            $ticket->setEstado('Terminado');
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('homepage');
    }

    /**
     * Creates a new ticket entity.
     *
     * @Route("/new", name="ticket_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $userEm = $this->getDoctrine()->getManager();
        $tecnicos = $userEm->getRepository('AppBundle:User')->findAll();

        $ticket = new Ticket();

        $form = $this->createForm('AppBundle\Form\TicketType', $ticket, array(
            'tecnicos' => $tecnicos
        ));
        $form->handleRequest($request);

        $user = $this->getUser();

        $ticket->setUsuario($user);
        $ticket->setFecha(new \DateTime());
        $ticket->setEstado('Pendiente');

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();

            return $this->redirectToRoute('ticket_show', array('id' => $ticket->getId()));
        }

        return $this->render('ticket/new.html.twig', array(
            'ticket' => $ticket,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ticket entity.
     *
     * @Route("/{id}", name="ticket_show")
     * @Method("GET")
     */
    public function showAction(Ticket $ticket)
    {
        $deleteForm = $this->createDeleteForm($ticket);

        $user = $this->getUser();

        if(is_null($user)){
            return $this->redirectToRoute('login', array('id' => $ticket->getId()));
        }

        $roles = $user->getRoles();
        $role = array_values($roles)[0];

        $notas = $ticket->getNotas();

        return $this->render('ticket/show.html.twig', array(
            'ticket' => $ticket,
            'delete_form' => $deleteForm->createView(),
            'role' => $role,
            'notas' => $notas,
            'user' => $user
        ));
    }

    /**
     * Displays a form to edit an existing ticket entity.
     *
     * @Route("/{id}/edit", name="ticket_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ticket $ticket)
    {
        $deleteForm = $this->createDeleteForm($ticket);
        $editForm = $this->createForm('AppBundle\Form\TicketType', $ticket);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ticket_edit', array('id' => $ticket->getId()));
        }

        return $this->render('ticket/edit.html.twig', array(
            'ticket' => $ticket,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ticket entity.
     *
     * @Route("/{id}", name="ticket_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ticket $ticket)
    {
        $form = $this->createDeleteForm($ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ticket);
            $em->flush();
        }

        return $this->redirectToRoute('ticket_index');
    }

    /**
     * Creates a form to delete a ticket entity.
     *
     * @param Ticket $ticket The ticket entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ticket $ticket)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ticket_delete', array('id' => $ticket->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
