<?php

namespace ViewOrdersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {
    public function indexAction() {
		
		$request = Request::createFromGlobals();
		$params = $request->query->All();
		
		$sort = "user"; //default sorting field: customers' lastnames+names
		$direction = "asc"; //default sorting direction: ascending
		$udir = "asc"; //sorting direction for customers' names
		if (!empty($params['sort'])) {
			 $sort = $params['sort']; //user, prod, price, count, cost
		}
		if (!empty($params['d'])) {
			 $direction = $params['d']; //asc, desc
		}
		if (!empty($params['ud'])) {
			$udir = $params['ud'];
		}
		if (!in_array($sort, array("user", "prod", "price", "count", "cost"))) {
			$sort = "user";
		}
		if (!in_array($direction, array("asc", "desc"))) {
			$direction = "asc";
		}
		if (!in_array($udir, array("asc", "desc"))) {
			$udir = "asc";
		}
		
		$appAuthor = array("name" => "Maria", "surname" => "Valyukh");
		
		$entityManager = $this->getDoctrine()->getManager();
	
		$add_sort = "";
		
		if ($sort == 'prod') {
			$add_sort = ', p.name '.strtoupper($direction);
		} 
		else if ($sort == 'price') {
			$add_sort = ', o.price '.strtoupper($direction);
		} 
		else if ($sort == 'count') {
			$add_sort = ', o.count '.strtoupper($direction);
		}
		else if ($sort == 'cost') {
			$add_sort = ', cost '.strtoupper($direction);
		}
		
		$query = $entityManager
			->createQuery(
				'SELECT o, c, p, o.price*o.count AS cost FROM ViewOrdersBundle:Orders o '
				. 'LEFT JOIN o.customer c '
				. 'LEFT JOIN o.product p '
				. 'ORDER BY c.lastname '.strtoupper($udir).', c.name '.strtoupper($udir). $add_sort 
				//.'WHERE o.id = :id'
		); //->setMaxResults(10); //->setFirstResult(0); //->setParameter('id', 12);
/*
		$querySum = $entityManager
			->createQuery(
				'SELECT c.id, SUM(o.price*o.count) AS total FROM ViewOrdersBundle:Orders o '
				. 'LEFT JOIN o.customer c '
				. 'GROUP BY c.id '
		);
*/		
		//$sql=$querySum->getSQL(); 
		
		try {
			$res = $query->getResult(); // ->getSingleResult() - для одной записи, ->getResult() - когда возвр. много записей
		} catch (\Doctrine\ORM\NoResultException $e) {
			return null;
		}
		
		$orders = array();
		foreach ($res as $r) {
			$order = array();
			$order['id'] = $r[0]->getId();
			$order['product_name'] = $r[0]->getProduct()->getName();
			$order['customer_name'] = $r[0]->getCustomer()->getLastname() ." ". $r[0]->getCustomer()->getName();
			$order['customer_id'] = $r[0]->getCustomer()->getId();
			$order['price'] = $r[0]->getPrice();
			$order['count'] = $r[0]->getCount();
			$order['cost'] = $r['cost'];
			$orders[] = $order;
		}
		$customers = array();
		foreach ($orders as $o) {
			$customers[$o['customer_id']]['orders'][] = $o;
		}
		foreach ($customers as &$c) {
			$total = 0;
			foreach ($c['orders'] as $o) {
				$total += floatval($o['cost']);
			}
			$c['total'] = $total;
			$c['full_name'] = $c['orders'][0]['customer_name'];
		}
		
		//echo "<pre>";
		//echo count($res);
		//var_dump($res[0]);
		//print_r($customers);
		//echo "</pre>";
 
		return $this->render(
				'ViewOrdersBundle:Default:index.html.twig', 
				array(
					'author' => $appAuthor,
					'customers' => $customers, 
					'udir' => $udir
					)
				);
    }
}


/*
SELECT c.lastname, c.name, o.price, o.date_create, o.count, p.name, p.price as new_price, o.price*o.count as cost
FROM customers as c
LEFT JOIN orders as o ON o.customer_id=c.id
LEFT JOIN products as p ON o.product_id=p.id
ORDER BY c.lastname, c.name;


SELECT o.customer_id, SUM(o.price*o.count) as total
FROM orders as o
GROUP BY o.customer_id;
 */