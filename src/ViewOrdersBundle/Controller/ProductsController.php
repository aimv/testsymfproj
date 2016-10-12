<?php

namespace ViewOrdersBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ViewOrdersBundle\Entity\Products;
use ViewOrdersBundle\Form\ProductsType;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Products controller.
 *
 */
class ProductsController extends Controller {

	public function paginate($dql, $page = 1, $limit = 25) {
		$paginator = new Paginator($dql);
		$paginator->getQuery()
				->setFirstResult($limit * ($page - 1)) //Offset
				->setMaxResults($limit); //Limit
		return $paginator;
	}
	
	/**
	 * Lists all Products entities.
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
		else if ($sort == "price") {
			$sort_field = "price";
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
		
		$products = $em->createQuery(
				'SELECT p FROM ViewOrdersBundle:Products p '
				. 'ORDER BY p.'.$sort_field.' '.$sort_dir
		);

		$paginator = $this->paginate($products, $page, $limit);

		$maxPages = ceil($paginator->count() / $limit);
		$thisPage = $page;

		return $this->render('products/index.html.twig', array(
					'products' => $paginator->getQuery()->getResult(),
					'limit' => $limit,
					'max_pages' => $maxPages,
					'this_page' => $thisPage, 
					'sort' => $sort_field,
					'dir' => $sort_dir
		));
	}

	/**
	 * Creates a new Products entity.
	 *
	 */
	public function newAction(Request $request) {
		$product = new Products();
		$form = $this->createForm('ViewOrdersBundle\Form\ProductsType', $product);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($product);
			$em->flush();

			return $this->redirectToRoute('products_show', array('id' => $product->getId()));
		}

		return $this->render('products/new.html.twig', array(
					'product' => $product,
					'form' => $form->createView(),
		));
	}

	/**
	 * Finds and displays a Products entity.
	 *
	 */
	public function showAction(Products $product) {
		$deleteForm = $this->createDeleteForm($product);

		return $this->render('products/show.html.twig', array(
					'product' => $product,
					'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Displays a form to edit an existing Products entity.
	 *
	 */
	public function editAction(Request $request, Products $product) {
		$deleteForm = $this->createDeleteForm($product);
		$editForm = $this->createForm('ViewOrdersBundle\Form\ProductsType', $product);
		$editForm->handleRequest($request);

		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($product);
			$em->flush();

			return $this->redirectToRoute('products_edit', array('id' => $product->getId()));
		}

		return $this->render('products/edit.html.twig', array(
					'product' => $product,
					'edit_form' => $editForm->createView(),
					'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Deletes a Products entity.
	 *
	 */
	public function deleteAction(Request $request, Products $product) {
		$form = $this->createDeleteForm($product);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($product);
			$em->flush();
		}

		return $this->redirectToRoute('products_index');
	}

	/**
	 * Creates a form to delete a Products entity.
	 *
	 * @param Products $product The Products entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm(Products $product) {
		return $this->createFormBuilder()
						->setAction($this->generateUrl('products_delete', array('id' => $product->getId())))
						->setMethod('DELETE')
						->getForm()
		;
	}

}
