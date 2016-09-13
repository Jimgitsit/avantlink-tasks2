<?php

namespace AvantLink\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller {
	/**
	 * @Route("/")
	 */
	public function indexAction() {
		$tasks = $this->getDoctrine()->getRepository('AvantLinkAPIBundle:Task')->findAll();
		
		return $this->render('AvantLinkAPIBundle:Default:tasks.html.twig', array('tasks' => $tasks));
	}
}
