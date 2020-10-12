<?php
	include 'inc/header.php';
?>
<?php
	//Session::init();
	//echo session_id();
?>

 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>Your Cart</h2>
						<table class="tblone">
							<tr>
								<th width="5%">No.</th>
								<th width="15%">Product Name</th>
								<th width="10%">Image</th>
								<th width="15%">Price</th>
								<th width="25%">Quantity</th>
								<th width="20%">Total Price</th>
								<th width="10%">Action</th>
							</tr>
							<?php
								$subTotal = 0;
								if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
									$i = 0;
									foreach ($_SESSION['cart'] as $key => $value) {						
										$i++;
										$subTotal += ($value['price'] * $value['qty']);	
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $value['productName']; ?></td>
								<td><img src="admin/uploads/<?php echo $value['image'] ?>" style="height: 40px ; width: 50px ; image-rendering: pixelated" alt=""/></td>
								<td><?php echo '$'.number_format($value['price']) ?></td>
								<td>
									<form action="" method="post" id="updateCart">
										<input type="hidden" name="productId" class="productId" value="<?php echo $value['productId'] ?>">
										<input type="hidden" name="price" class="price" value="<?php echo $value['price'] ?>">
										<input type="number"  max="100" class="qty" value="<?php echo $value['qty'] ?>"/>
										<input type="submit" name="updateQty" class="updateQty" value="Update"/>
									</form>
								</td>
								<td class="totalPrice"><?php echo '$'.number_format($value['price'] * $value['qty']) ?></td>
								<td><a style='cursor :pointer' class="cart_quantity_delete" id="<?php echo $value['productId'] ?>">X</a></td>
			

							</tr>	
							<?php		
																
									}
								}

					   		?>	
						</table>
						<br>
						<br>
						<table style="float:right;text-align:left;" width="40%">
							<tr>
								<th>Sub Total : </th>
								<td id="subTotal" class="<?php echo $subTotal; ?>">
									<?php 
											echo '$'.number_format($subTotal); 
									?>	
								</td>
							</tr>
					   </table>
			</div>
			<div class="shopping">
				<div class="shopleft">
					<a href="index.php"> <img src="images/shop.png" alt="" /></a>
				</div>
				<div class="shopright">
					<a href="payment.php"> <img src="images/check.png" alt="" /></a>
				</div>
			</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 	<script type="text/javascript">

			//update cart
			$(".updateQty").click(function(){
				
				var id = $(this).closest('#updateCart').find('.productId').attr('value');
				var price = $(this).closest('#updateCart').find('.price').attr('value');	
				var qty    = $(this).closest('#updateCart').find('.qty').val();
				var subTotal = $('#subTotal').attr('class'); 
				var abc = $(this);
				//console.log(subTotal);
				//alert(qty)

				$.ajax({
					method: "POST",// phương thức dữ liệu được truyền đi
					url: "ajax.php",// gọi đến file server addToCart.php để xử lý

					data: {
						id:id,
						price:price,
						qty:qty,
						subTotal:subTotal
					},//lấy toàn thông tin các fields trong form 
		            success:function(msg){
						//var b = JSON.parse(JSON.stringify(msg));
						
						//console.log(typeof msg);
						var b = msg.replace(/^\s+|\s+$/g, "");
						console.log(b);
						var c = JSON.parse(b);
						console.log(c);
						if (c.qty <= 0) {
							abc.closest('tr').remove();
						}
						//console.log(typeof c)
						//abc.prev().attr('value',c.qty);
						abc.closest('tr').find('.totalPrice').text(c.totalPrice);
						console.log(c)
		            },
		            error:function(msg){
		                console.log("failed");
		            }
				});
				return false;
			});	

			//delete
			$(".cart_quantity_delete").click(function() {
    			var idDelete = $(this).attr('id');
    			var abc = $(this);
    			//alert(idDelete);

    			$.ajax({
					method: "POST",// phương thức dữ liệu được truyền đi
					url: "ajax.php",// gọi đến file server addToCart.php để xử lý
					data: {idDelete:idDelete},//lấy toàn thông tin các fields trong form 
					success : function(data){//kết quả trả về từ server nếu gửi thành công
						//console.log($(this));	
						abc.closest('tr').remove();
					}
				});
    		});

	</script>

 <?php
	include 'inc/footer.php';
?>


