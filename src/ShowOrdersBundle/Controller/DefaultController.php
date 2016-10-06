<?php

namespace ShowOrdersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

	public function indexAction() {
		$appAuthor = array("name" => "Maria", "surname" => "Valyukh");
		
		//$em = $this->getDoctrine()->getManager();
		//$query = $em->createQuery(
		//		'SELECT o FROM ShowOrdersBundle:Orders o'
		//		  . 'LEFT JOIN o.customer_id c '
				//. 'LEFT JOIN o.product_id p'
				//. 'ORDER BY c.lastname, c.name'
				//. 'LIMIT 10'
		//	);
		//$orders = $query->getResult();
		/*
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
			'SELECT o FROM ShowOrdersBundle:Orders o'
		);
		$res = $query->getResult();
*/
		$query = $this->getDoctrine()->getManager()
			->createQuery(
				'SELECT o, c FROM ShowOrdersBundle:Orders o
				JOIN o.customer_id c
				WHERE o.id = :id'
			)->setParameter('id', 12);

		try {
			$res = $query->getSingleResult();
		} catch (\Doctrine\ORM\NoResultException $e) {
			return null;
		}
	
		echo "<pre>";
		print_r($res);
		echo "</pre>";
		
		//$queryBuilder = $this->getDoctrine()
		//		->getRepository('ShowOrdersCustomers')
		//		->createQueryBuilder('c');
		//$queryBuilder
	//			->select('select')
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
		return $this->render(
				'ShowOrdersBundle:Default:index.html.twig', 
				array(
					'author' => $appAuthor,
					'customers' => array(
							array("name"=>"John", "lastname"=>"Smith", "id"=>12),
							array("name"=>"Sue", "lastname"=>"Johnes", "id"=>2),
							array("name"=>"Ann", "lastname"=>"Brown", "id"=>30),
						)
					)
				);
	}

}
