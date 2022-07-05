add_action( 'woocommerce_order_status_processing', 'order_stats' );

function order_stats($order_id) {
	
	$order = new WC_Order($post->ID);
	$customer_id = $order->get_customer_id();
	$order_obj = wc_get_order( $order_id );
	$data  = $order_obj->get_data();
	$items_in_order = array();
	$order_items = $order_obj->get_items();
	$i = 0;
	foreach( $order_items as $item ) {
	  $items_in_order[$i] = array (
		  'id' => 			$item->get_product_id(),
		  'ean' =>			$item->get_product(),
		  'code' => 		$item->get_variation_id(),
		  'amount' => 		$item->get_quantity(),
		  'note' =>  		$item->get_meta_data()
			);
		$i++;
	}	
	
	$postdata = array (
		  'delpay_id' => 			$order_id,
		  'currency' => 			$order->get_currency(),
		  'external_order' => 		'EXT0001',
		  'customer_note' => 		$order->get_customer_note(),
		  'additonal_note' => 		'Interní poznámka',
		  'additonal_text' => 		'Pohoda text',
		  'referrer' => 			'Zdroj objednávky',
		  'delivery_address' => 
		 array (
			'first_name' => 	$data['shipping']['first_name'],
			'last_name' => 		$data['shipping']['last_name'],
			'company' => 		$data['shipping']['company'],
			'street' => 		'Na rozhraní 654',
			'city' => 			$data['shipping']['city'],
			'region' => 		'Api region',
			'zip' => 			$data['shipping']['postcode'],
			 'phone' =>  		$order_data['shipping']['phone'],
			'country_code' =>  	$data['shipping']['state'],
			'email' =>			$data['shipping']['email']
				  ),
			'items' => $items_in_order
		);

	$options = array(
	  'http' => array(
		'method'  => 'POST',
		'content' => json_encode( $postdata ),
		'header'=>  "Content-Type: application/json\r\n" .
					"Accept: application/json\r\n"
		)
	);
	$context = stream_context_create($options);
	$result = file_get_contents('http://REDACTED.183:REDACTED', false, $context);
	echo $result;
}