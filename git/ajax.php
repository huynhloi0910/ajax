<?php
	include_once 'classes/product.php';
	include_once 'lib/session.php';
	Session::init();
	// Session::destroy();

	//shopping cart
	$prd = new Product();
	if (isset($_POST['productId'])) {

		$productId = $_POST["productId"];
		$qty = $_POST['qty'];
		$getProductByIdToCart = $prd->getProductByIdToCart($productId);

		$checkProduct = true;


		$existed = 'This Product Has Already In The Cart';
		$exist   = 'Product Added Successfully';

		if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
			foreach ($_SESSION['cart'] as $key => $value) {
				if ($key == $productId) {
					echo $existed;
					$checkProduct = false;
				} 
			}
		} 

		if ($checkProduct) {

			$data = array(

					'productId'   => $productId,
					'productName' => $getProductByIdToCart['productName'],
					'image'       => $getProductByIdToCart['image'],
					'price'       => $getProductByIdToCart['price'],
					'qty'         => $qty

			);

			$_SESSION['cart'][$productId] = $data;
			echo $exist;
		}

		if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
			$countProduct = count($_SESSION['cart']);
			//echo $countProduct;
		}

		// $title = [
		// 	'existed' => $existed,
		// 	'exist'   => $exist
		// ];
		// // echo "<pre>";
		// // print_r($_SESSION['cart']);
		// // echo "</pre>";
		// $arr = [
		// 	'count' => $countProduct,
		// 	'note' => $title
		// ];

		// print_r($arr);
	} 
?>

<?php
	$data = [];
	if (isset($_POST['id'])) {

		$id = $_POST['id'];
		$price = $_POST['price'];
		$qty   = $_POST['qty'];
		$subTotal   = $_POST['subTotal'];
		//print_r($subTotal);

		$data['subTotal'] = 0;
		if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
			$data['count'] = count($_SESSION['cart']);
			// echo "<pre>";
		 	//print_r($_SESSION['cart'][$id]['qty']);
			// echo "</pre>";
			foreach ($_SESSION['cart'] as $key => $value) {
				$data['subTotal'] += ($qty * $price);
				if ($_POST['id'] == $value['productId']) {
					//print_r($subTotal);

					$_SESSION['cart'][$id]['qty'] = $qty;

					$data['qty'] = $_SESSION['cart'][$id]['qty'];
					//print_r($qty);

					$data['totalPrice'] = '$'.number_format($_SESSION['cart'][$id]['price'] * $data['qty']);

					//$subTotal = $data['subTotal'] + ($qty * $price);
					$data['subTotal'] += $_SESSION['cart'][$id]['price'];
					//print_r($subTotal);
					
				}
			}
		}

		if ($qty <= 0) {
			unset($_SESSION['cart'][$id]);
		}

		echo json_encode($data);	 

	}

?>


<?php
	//delete cart X
	if (isset($_POST['idDelete'])) {
		$idDelete = $_POST['idDelete'];
		unset($_SESSION['cart'][$idDelete]);
	}
?>	