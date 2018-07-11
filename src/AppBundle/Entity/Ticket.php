<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="descripccion", type="string", length=1000)
     */
    private $descripccion;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tickets")
     * @ORM\JoinColumn(name="tecnico_id", referencedColumnName="id")
     */
    private $tecnico;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var int
     *
     * @ORM\Column(name="usuario_id", type="integer")
     */
    private $usuarioId;

    /**
     * @var int
     *
     * @ORM\Column(name="tecnico_id", type="integer")
     */
    private $tecnicoId;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set descripccion
     *
     * @param string $descripccion
     *
     * @return Ticket
     */
    public function setDescripccion($descripccion)
    {
        $this->descripccion = $descripccion;

        return $this;
    }

    /**
     * Get descripccion
     *
     * @return string
     */
    public function getDescripccion()
    {
        return $this->descripccion;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Ticket
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set usuarioId
     *
     * @param integer $usuarioId
     *
     * @return Ticket
     */
    public function setUsuarioId($usuarioId)
    {
        $this->usuarioId = $usuarioId;

        return $this;
    }

    /**
     * Get usuarioId
     *
     * @return int
     */
    public function getUsuarioId()
    {
        return $this->usuarioId;
    }

    /**
     * Set tecnicoId
     *
     * @param integer $tecnicoId
     *
     * @return Ticket
     */
    public function setTecnicoId($tecnicoId)
    {
        $this->tecnicoId = $tecnicoId;

        return $this;
    }

    /**
     * Get tecnicoId
     *
     * @return int
     */
    public function getTecnicoId()
    {
        return $this->tecnicoId;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Ticket
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }
}

