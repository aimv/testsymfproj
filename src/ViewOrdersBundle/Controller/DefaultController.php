<?php

namespace ViewOrdersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\Tools\Pagination\Paginator;



class DefaultController extends Controller {
	
	public function paginate($dql, $page = 1, $limit = 25) {
		$paginator = new Paginator($dql);
		
				
		$paginator->getQuery()
				->setFirstResult($limit * ($page - 1)) //Offset
				->setMaxResults($limit); //Limit
		//echo $paginator->getQuery()->getSql();
		return $paginator;
	}

	public function getAllOrders($udir, $sort_field, $sort_dir, $currentPage = 1, $limit = 25) {
		$entityManager = $this->getDoctrine()->getManager();
		$qb = $entityManager->createQueryBuilder();
		$qb->select('o, c, p, o.price*o.count AS cost')
				->from('ViewOrdersBundle:Orders', 'o')
				->leftJoin('o.customer', 'c', 'WITH', 'c.id = o.customer')
				->leftJoin('o.product', 'p', 'WITH', 'p.id = o.product')
				->orderBy('c.lastname', strtoupper($udir))
				->addOrderBy('c.name', strtoupper($udir))
				->addOrderBy($sort_field, $sort_dir) //additional sorting of orders for each customer
				;
		
	/*
		$query = $entityManager
			->createQuery(
				'SELECT o, c, p, o.price*o.count AS cost FROM ViewOrdersBundle:Orders o '
				. 'LEFT JOIN o.customer c '
				. 'LEFT JOIN o.product p '
				. 'ORDER BY c.lastname '.strtoupper($udir).'	, c.name '.strtoupper($udir). $add_sort 
				//.'WHERE o.id = :id'
		); 
		try {
			$res = $query->getResult(); // ->getSingleResult() - для одной записи, ->getResult() - когда возвр. много записей
		} catch (\Doctrine\ORM\NoResultException $e) {
			return null;
		}
	*/	
		
		$paginator = $this->paginate($qb, $currentPage, $limit);

		return $paginator;
	}
	
	
    public function indexAction($page = 1) {
		
		$request = Request::createFromGlobals();
		$params = $request->query->All();
		
		$sort = "user"; //default sorting field: customers' lastnames+names
		$direction = "ASC"; //default sorting direction: ascending
		$udir = "ASC"; //sorting direction for customers' names
		if (!empty($params['sort'])) {
			 $sort = $params['sort']; //user, prod, price, count, cost
		}
		if (!empty($params['d'])) {
			 $direction = $params['d']; //asc, desc
		}
		if (!empty($params['ud'])) {
			$udir = strtoupper($params['ud']);
		}
		if (!in_array($sort, array("user", "prod", "price", "count", "cost"))) {
			$sort = "user";
		}
		if (!in_array(strtoupper($direction), array("ASC", "DESC"))) {
			$direction = "ASC";
		}
		if (!in_array(strtoupper($udir), array("ASC", "DESC"))) {
			$udir = "ASC";
		}
				
		//sorting direction
		$sort_dir = strtoupper($direction); 
		//page
		if (!empty($params['page'])) {
			$page = (int)$params['page'];
		}
	
		$appAuthor = array("name" => "Maria", "surname" => "Valyukh");
		
		//sorting field 
		$sort_field = "p.name";
		if ($sort == 'prod') {
			$sort_field = 'p.name ';
		} 
		else if ($sort == 'price') {
			$sort_field = 'o.price';
		} 
		else if ($sort == 'count') {
			$sort_field = 'o.count';
		}
		else if ($sort == 'cost') {
			$sort_field = 'cost';
		}
		
		$limit = 10;
		
		$paginator_orders = $this->getAllOrders($udir, $sort_field, $sort_dir, $page, $limit); //Paginator
		$res = $paginator_orders->getQuery()->getResult();

		$maxPages = ceil($paginator_orders->count() / $limit);
		$thisPage = $page;		
		
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
 
		return $this->render(
				'ViewOrdersBundle:Default:index.html.twig', 
				array(
					'author' => $appAuthor,
					'customers' => $customers, 
					'udir' => $udir,
					'limit' => $limit,
					'max_pages' => $maxPages,
					'this_page' => $thisPage,
					'sort' => $sort,
					'd' => $direction,
					'ud' => $udir
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