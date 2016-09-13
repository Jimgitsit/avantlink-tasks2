<?php

namespace AvantLink\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use AvantLink\APIBundle\Entity\Task;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;

class APIController extends FOSRestController {
	private $format = 'json';
	private $headers = array(
		'content-type' => 'application/json'
	);
	
	/**
	 * Returns a task.
	 *
	 * @ApiDoc(
	 *     resource=true,
	 *     description="Returns a task.",
	 *     requirements={{"name"="id", "dataType"="integer","requirement"="\d+","description"="The id of the task to retrieve."}}
	 * )
	 *
	 * @Get("/api/tasks/{id}", requirements={"id" = "\d+"})
	 *
	 * @param $id
	 *
	 * @return Response
	 */
	public function getTaskAction($id) {
		$task = $this->getDoctrine()->getRepository('AvantLinkAPIBundle:Task')->find($id);
		
		$serializer = $this->get('jms_serializer');
		
		if (empty($task)) {
			return new Response($serializer->serialize("Task with id $id does not exist.", $this->format), 200, $this->headers);
		}
		
		return new Response($serializer->serialize($task, $this->format), 200, $this->headers);
	}
	
	/**
	 * Adds a task.
	 *
	 * @ApiDoc(
	 *     resource=true,
	 *     description="Adds a task.",
	 *     requirements={{"name"="title", "dataType"="string","requirement"="100 chars max","description"="The title of the task."}}
	 * )
	 *
	 * @Post("/api/tasks/add")
	 *
	 * @param Request $request the request object
	 *
	 * @return Response
	 */
	public function addTaskAction(Request $request) {
		$title = $request->get('title');
		
		$serializer = $this->get('jms_serializer');
		
		if (strlen($title) > 100) {
			return new Response($serializer->serialize("The maximum length for title is 100 characters.", $this->format), 400, $this->headers);
		}
		
		$task = new Task();
		$task->setTitle($title);
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($task);
		$em->flush();
		
		return new Response($serializer->serialize($task, $this->format), 200, $this->headers);
	}
	
	/**
	 * Removes a task.
	 *
	 * @ApiDoc(
	 *     resource=true,
	 *     description="Removes a task.",
	 *     requirements={{"name"="id", "dataType"="integer","requirement"="\d+","description"="The id of the task to remove."}}
	 * )
	 *
	 * @Get("/api/tasks/remove/{id}")
	 *
	 * @param $id
	 *
	 * @return Response
	 */
	public function removeTaskAction($id) {
		$task = $this->getDoctrine()->getRepository('AvantLinkAPIBundle:Task')->find($id);
		$em = $this->getDoctrine()->getManager();
		
		$serializer = $this->get('jms_serializer');
		
		$msg = "Task with id $id was removed.";
		if ($task !== null) {
			$em->remove($task);
			$em->flush();
		}
		else {
			$msg = "Task with id $id does not exist.";
		}
		
		return new Response($serializer->serialize($msg, $this->format), 200, $this->headers);
	}
	
	/**
	 * Returns all tasks.
	 *
	 * @ApiDoc(
	 *     resource=true,
	 *     description="Returns all tasks."
	 * )
	 *
	 * @Get("/api/tasks/all")
	 *
	 * @return Response
	 */
	public function getAllTasksAction() {
		$tasks = $this->getDoctrine()->getRepository('AvantLinkAPIBundle:Task')->findAll();
		
		$serializer = $this->get('jms_serializer');
		
		return new Response($serializer->serialize($tasks, $this->format), 200, $this->headers);
	}
}