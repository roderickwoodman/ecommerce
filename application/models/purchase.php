<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Purchase extends CI_Model {

	public function get_all_products()
	{


		$query = "SELECT * FROM products";
		
		return $this->db->query($query)->result_array();
	}

	public function count($post)
	{

	}

	public function get_products_by_category($category_id)
	{	
		$query= "SELECT products.name, products.price FROM products
			LEFT JOIN product_categories ON products.id = product_categories.product_id
			 LEFT JOIN categories ON product_categories.category_id = categories.id
			 WHERE categories.id = ?";

		return $this->db->query($query, array($category_id))->result_array();
	}

	public function get_all_categories()
	{
		$query = "SELECT * FROM categories";

		return $this->db->query($query)->result_array();
	}

	public function get_category_counts()
	{
		$query= "SELECT categories.id as category_id, categories.name as category_name, COUNT(category_id) as category_count FROM products
			LEFT JOIN product_categories ON products.id = product_categories.product_id
			 LEFT JOIN categories ON product_categories.category_id = categories.id
             GROUP BY category_id";
		// var_dump($query);
		// die();
		return $this->db->query($query)->result_array();
	}

	public function get_product_by_id($id)
	{
		$query = "SELECT * FROM products WHERE id  = ?";

		return $this->db->query($query, $id)->row_array();
	}

	public function load_cart()
	{
		$cart_items = $this->session->userdata('cart_items');
		if(empty($cart_items)){ return; }
		$query = "SELECT products.id, products.name, products.price FROM products WHERE ";
		$first = true;
		foreach($cart_items as $product_id => $quantity){ 
			if (!$first) {
				$query .= "OR ";
			}
			else {
				$first = false;
			}
			$query .= "(products.id = ".$product_id.") ";
		}
		return $this->db->query($query)->result_array();
	}

}
	

	// public function new_order($post)
	// {
	// 	$query = "INSERT INTO billings (shipping_first, shipping_last,
	// 	 	shipping_address, shipping_city, shipping_state, shipping_zip,
	// 	 	billing_first, billing_last, billing_city, billing_zip, card,
	// 	 	security, expiration, created_at, updated_at)
	// 		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?, NOW(), NOW())";
	// 	return $this->db->query($query, $post)-> /*get billings.id */ ;

	// 	$query = "INSERT INTO orders (billing_id, total_price, status, created_at, updated_at)
	// 	 		VALUES (?, ?, ?, NOW(), NOW())";
	// 	return $this->db->query($query, array();

	// 	$query = "INSERT INTO product_orders (order_id, product_id) VALUES (?,?)";
	// 	return $this->db->query($query, array());

	// 	$query = "UPDATE products SET in_stock = ?, quantity_sold = ?, updated_at = NOW() WHERE id = ?";
	// 	return $this->db->query($query, array());

	// }
