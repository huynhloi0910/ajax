<?php
	include 'inc/header.php';
?>
<?php
	if (!isset($_GET['productId']) && $_GET['productId'] == NULL) {
        echo "<script> window.location = '404.php' </script>";
    } else {
        $productId = $_GET['productId'];
    }

    //Compare Product
    $customerId = Session::get('customerId');
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['compareProduct'])){
        // LẤY DỮ LIỆU TỪ PHƯƠNG THỨC Ở FORM POST
        $productId = $_POST['productId'];
        $insertCompare = $cpr -> insertCompare($productId, $customerId); 
    }

    //Save to Wishlist
    $customerId = Session::get('customerId');
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wishlistProduct'])){
        // LẤY DỮ LIỆU TỪ PHƯƠNG THỨC Ở FORM POST
        $productId = $_POST['productId'];
        $insertWhislist = $cpr -> insertWhislist($productId, $customerId); 
    }


    // $customerId = Session::get('customerId');
    // if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addToCart'])){
    //     // LẤY DỮ LIỆU TỪ PHƯƠNG THỨC Ở FORM POST
    //     // $productId = $_POST['productId'];
    //    	// $qty = $_POST['qty'];

    //    	$getProductByIdToCart = $prd -> getProductByIdToCart($productId); 
    //    	// echo "<pre>";
    //    	// var_dump($getProductByIdToCart);
    //    	// echo "</pre>";
   	
    // }

?>
<style type="text/css">
	.note {
		color: red;
	}
</style>
 <div class="main">
    <div class="content">
    	<div class="section group">
    		<?php
    			$getProductDetails = $prd->getProductDetails($productId);
    			if ($getProductDetails) {
    				while ($resultDetails = $getProductDetails->fetch_assoc()) {
    		?>
			<div class="cont-desc span_1_of_2">				
				<div class="grid images_3_of_2">
					<img src="admin/uploads/<?php echo $resultDetails['image'] ?>" style="height: 200px; image-rendering: pixelated" alt="" />
				</div>
				<div class="desc span_3_of_2">
					<h2><?php echo $resultDetails['productName'] ?></h2>
					<p><?php echo $resultDetails['productDesc'] ?></p>					
					<div class="price">
						<p>Price: <span><?php echo '$'.number_format($resultDetails['price'])?></span></p>
						<p>Category: <span><?php echo $resultDetails['catName'] ?></span></p>
						<p>Brand:<span><?php echo $resultDetails['brandName'] ?></span></p>
					</div>
					<!-- add to cart -->
					<div class="add-cart" id="addCart">
						<form action="" method="POST">
							<input type="hidden" name="productId" class="productId" value="<?php echo $resultDetails['productId'] ?>"/>
							<input type="hidden" name="productName" class="productName" value="<?php echo $resultDetails['productName'] ?>"/>
							<input type="hidden" name="image" class="image" value="<?php echo $resultDetails['image'] ?>"/>
							<input type="hidden" name="price" class="price" value="<?php echo $resultDetails['price'] ?>"/>
							<input type="number" name="qty" class="qty" min="1" max="100" class="buyfield" value="1"/>
							<input type="submit" name="addToCart" class="buysubmit" id="addToCart" value="Buy Now"/>
							<p class="success" style="color: green"></p>
						</form>				
					</div>
					<!-- so sánh sản phẩm -->
					<div class="add-cart">
						<div class="button_details">
							<form action="" method="post">
								<input type="hidden" name="productId" value="<?php echo $resultDetails['productId'] ?>"/>		
							<?php
							//Khi người dùng đã đăng nhập thì mới hiện nút compareProduct và Save to Whilist
						 		$loginCheck = Session::get('customerLogin');
								if ($loginCheck) {
									echo '<input type="submit" class="buysubmit" name="compareProduct" value="Compare Product"/>'.' ';
								} else {
									echo '';
								}
							?>	

							</form>	

							<form action="" method="post">
								<input type="hidden" name="productId" value="<?php echo $resultDetails['productId'] ?>"/>		
							<?php
							//Khi người dùng đã đăng nhập thì mới hiện nút compareProduct và Save to Whilist
						 		$loginCheck = Session::get('customerLogin');
								if ($loginCheck) {
									echo '<input type="submit" class="buysubmit" name="wishlistProduct" value="Save to Wishlist"/>';
								} else {
									echo '';
								}
							?>	

							</form>				
						</div>
						<div class="clear"></div>
						<?php
							if (isset($insertCompare)) {
								echo $insertCompare;
							}
						?>
						
						<?php
							if (isset($insertWhislist)) {
								echo $insertWhislist;
							}
						?>
					</div>
				</div>
					<div class="product-desc">
					<h2>Product Details</h2>
					<p><?php echo $resultDetails['productDesc'] ?></p>
			    	</div>
					
			</div>
			<?php
    				}
    			}
			?>
			<div class="rightsidebar span_3_of_1">
				<h2>CATEGORIES</h2>
				<ul>
				<?php
					$cat = $cat->showCategory();
					if ($cat) {
						while ($resultCat = $cat->fetch_assoc()) {
				?>
			      <li><a href="productbycat.php?catId=<?php echo $resultCat['catId'] ?>"><?php echo $resultCat['catName']; ?></a></li>
			    <?php
						}
					}
			    ?>
				</ul>

			</div>
 		</div>
 	</div>



	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 	<script type="text/javascript">

			//shopping cart
			$("#addToCart").click(function(e){
				e.preventDefault();
				var productId = $(this).closest('#addCart').find('.productId').attr('value');	
				var qty    = $(this).closest('#addCart').find('.qty').val();
				//console.log(qty)
				$.ajax({
					method: "POST",// phương thức dữ liệu được truyền đi
					url: "ajax.php",// gọi đến file server addToCart.php để xử lý
					data: {
						productId:productId,
						qty:qty
					},//lấy toàn thông tin các fields trong form
		            success:function(msg){
		            	$(".success").text(msg);
		            },
		            error:function(msg){
		                console.log("failed");
		            }
				});
				
			});	

	</script>

<?php
	include 'inc/footer.php';
?>

