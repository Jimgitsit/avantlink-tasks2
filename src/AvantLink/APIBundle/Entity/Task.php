<?php

namespace AvantLink\APIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @Entity
 * @Table(name="tasks")
 */
class Task {
	/**
	 * @Id
	 * @Column(type="integer")
	 * @GeneratedValue
	 */
	protected $id;
	
	/**
	 * @Column(type="string", length=100)
	 */
	protected $title;
	
	/**
	 * @Column(type="date")
	 */
	protected $created;
	
	/**
	 * Task constructor.
	 * Sets the created date.
	 */
	public function __construct() {
		$this->setCreated(new \DateTime());
	}
	
	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Set title
	 *
	 * @param string $title
	 *
	 * @return Task
	 */
	public function setTitle($title) {
		$this->title = $title;
		
		return $this;
	}
	
	/**
	 * Get title
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * Set created
	 *
	 * @param \DateTime $created
	 *
	 * @return Task
	 */
	public function setCreated($created) {
		$this->created = $created;
		
		return $this;
	}
	
	/**
	 * Get created
	 *
	 * @return \DateTime
	 */
	public function getCreated() {
		return $this->created;
	}
}
