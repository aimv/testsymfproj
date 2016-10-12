<?php

namespace ViewOrdersBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ViewOrdersBundle\Entity\Orders;
use ViewOrdersBundle\Form\OrdersType;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Orders controller.
 *
 */
class OrdersController extends Controller {

	public function paginate($dql, $page = 1, $limit = 25) {
		$paginator = new Paginator($dql);
		$paginator->getQuery()
				->setFirstResult($limit * ($page - 1)) //Offset
				->setMaxResults($limit); //Limit
		return $paginator;
	}
	
	/**
	 * Lists all Orders entities.
	 *
	 */
	public function indexAction($page = 1) {
		$em = $this->getDoctrine()->getManager();
		$limit = 20;
		
		$request = Request::createFromGlobals();
		$params = $request->query->All();
		// page 
		if (!empty($params['page'])) {
			$page = (int)$params['page'];
		}
		// sorting field 
		$sort_field = "id";
		$sort = "";
		if (!empty($params['sort'])) {
			$sort = $params['sort'];
		}
		if ($sort == "count") {
			$sort_field = "count";
		} 
		else if ($sort == "price") {
			$sort_field = "price";
		}
		else if ($sort == "created") {
			$sort_field = "created";
		}
		//sorting direction
		$sort_dir = "ASC";
		$dir = "";
		if (!empty($params['dir'])) {
			$dir = $params['dir'];
		}
		if (strtolower($dir) == "desc") {
			$sort_dir = "DESC";
		}
		
		$orders = $em->createQuery(
				'SELECT o FROM ViewOrdersBundle:Orders o '
				. 'ORDER BY o.'.$sort_field.' '.$sort_dir
		);

		$paginator = $this->paginate($orders, $page, $limit);

		$maxPages = ceil($paginator->count() / $limit);
		$thisPage = $page;

		return $this->render('orders/index.html.twig', array(
					'orders' => $paginator->getQuery()->getResult(),
					'limit' => $limit,
					'max_pages' => $maxPages,
					'this_page' => $thisPage, 
					'sort' => $sort_field,
					'dir' => $sort_dir
		));
	}

	/**
	 * Creates a new Orders entity.
	 *
	 */
	public function newAction(Request $request) {
		$order = new Orders();
		$form = $this->createForm('ViewOrdersBundle\Form\OrdersType', $order);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($order);
			$em->flush();

			return $this->redirectToRoute('orders_show', array('id' => $order->getId()));
		}

		return $this->render('orders/new.html.twig', array(
					'order' => $order,
					'form' => $form->createView(),
		));
	}

	/**
	 * Finds and displays a Orders entity.
	 *
	 */
	public function showAction(Orders $order) {
		$deleteForm = $this->createDeleteForm($order);

		return $this->render('orders/show.html.twig', array(
					'order' => $order,
					'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Displays a form to edit an existing Orders entity.
	 *
	 */
	public function editAction(Request $request, Orders $order) {
		$deleteForm = $this->createDeleteForm($order);
		$editForm = $this->createForm('ViewOrdersBundle\Form\OrdersType', $order);
		$editForm->handleRequest($request);

		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($order);
			$em->flush();

			return $this->redirectToRoute('orders_edit', array('id' => $order->getId()));
		}

		return $this->render('orders/edit.html.twig', array(
					'order' => $order,
					'edit_form' => $editForm->createView(),
					'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Deletes a Orders entity.
	 *
	 */
	public function deleteAction(Request $request, Orders $order) {
		$form = $this->createDeleteForm($order);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($order);
			$em->flush();
		}

		return $this->redirectToRoute('orders_index');
	}

	/**
	 * Creates a form to delete a Orders entity.
	 *
	 * @param Orders $order The Orders entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm(Orders $order) {
		return $this->createFormBuilder()
						->setAction($this->generateUrl('orders_delete', array('id' => $order->getId())))
						->setMethod('DELETE')
						->getForm()
		;
	}

}
