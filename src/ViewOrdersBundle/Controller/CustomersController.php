<?php

namespace ViewOrdersBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ViewOrdersBundle\Entity\Customers;
use ViewOrdersBundle\Form\CustomersType;

use Doctrine\ORM\Tools\Pagination\Paginator;


/**
 * Customers controller.
 *
 */
class CustomersController extends Controller {

	public function paginate($dql, $page = 1, $limit = 25) {
		$paginator = new Paginator($dql);
		$paginator->getQuery()
				->setFirstResult($limit * ($page - 1)) //Offset
				->setMaxResults($limit); //Limit
		return $paginator;
	}

	/**
	 * Lists all Customers entities.
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
		if ($sort == "name") {
			$sort_field = "name";
		}	
		else if ($sort == "lastname") {
			$sort_field = "lastname";
		}
		else if ($sort == "email") {
			$sort_field = "email";
		}
		else if ($sort == "created") {
			$sort_field = "date_create";
		}
		else if ($sort == "updated") {
			$sort_field = "date_update";
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
		
		//$customers = $em->getRepository('ViewOrdersBundle:Customers');//->findAll();
		$customers = $em->createQuery(
				'SELECT c FROM ViewOrdersBundle:Customers c '
				. 'ORDER BY c.'.$sort_field.' '.$sort_dir
		);

		$paginator = $this->paginate($customers, $page, $limit);

		$maxPages = ceil($paginator->count() / $limit);
		$thisPage = $page;

		return $this->render('customers/index.html.twig', array(
					'customers' => $paginator->getQuery()->getResult(),
					'limit' => $limit,
					'max_pages' => $maxPages,
					'this_page' => $thisPage, 
					'sort' => $sort_field,
					'dir' => $sort_dir
		));
	}

	/**
	 * Creates a new Customers entity.
	 *
	 */
	public function newAction(Request $request) {
		$customer = new Customers();
		$form = $this->createForm('ViewOrdersBundle\Form\CustomersType', $customer);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($customer);
			$em->flush();

			return $this->redirectToRoute('customers_show', array('id' => $customer->getId()));
		}

		return $this->render('customers/new.html.twig', array(
					'customer' => $customer,
					'form' => $form->createView(),
		));
	}

	/**
	 * Finds and displays a Customers entity.
	 *
	 */
	public function showAction(Customers $customer) {
		$deleteForm = $this->createDeleteForm($customer);

		return $this->render('customers/show.html.twig', array(
					'customer' => $customer,
					'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Displays a form to edit an existing Customers entity.
	 *
	 */
	public function editAction(Request $request, Customers $customer) {
		$deleteForm = $this->createDeleteForm($customer);
		$editForm = $this->createForm('ViewOrdersBundle\Form\CustomersType', $customer);
		$editForm->handleRequest($request);

		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($customer);
			$em->flush();

			return $this->redirectToRoute('customers_edit', array('id' => $customer->getId()));
		}

		return $this->render('customers/edit.html.twig', array(
					'customer' => $customer,
					'edit_form' => $editForm->createView(),
					'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Deletes a Customers entity.
	 *
	 */
	public function deleteAction(Request $request, Customers $customer) {
		$form = $this->createDeleteForm($customer);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($customer);
			$em->flush();
		}

		return $this->redirectToRoute('customers_index');
	}

	/**
	 * Creates a form to delete a Customers entity.
	 *
	 * @param Customers $customer The Customers entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm(Customers $customer) {
		return $this->createFormBuilder()
						->setAction($this->generateUrl('customers_delete', array('id' => $customer->getId())))
						->setMethod('DELETE')
						->getForm()
		;
	}

}
