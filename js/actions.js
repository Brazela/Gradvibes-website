$(document).ready(function () {
	cat();
	cathome();
	brand();
	product();

	producthome();


	//cat() is a funtion fetching category record from database whenever page is load
	function cat() {
		$.ajax({
			url: "action.php",
			method: "POST",
			data: { category: 1 },
			success: function (data) {
				$("#get_category").html(data);

			}
		})
	}
	function cathome() {
		$.ajax({
			url: "homeaction.php",
			method: "POST",
			data: { categoryhome: 1 },
			success: function (data) {
				$("#get_category_home").html(data);

			}
		})
	}
	//brand() is a funtion fetching brand record from database whenever page is load
	function brand() {
		$.ajax({
			url: "action.php",
			method: "POST",
			data: { brand: 1 },
			success: function (data) {
				$("#get_brand").html(data);
			}
		})
	}
	//product() is a funtion fetching product record from database whenever page is load
	function product() {
		$.ajax({
			url: "action.php",
			method: "POST",
			data: { getProduct: 1 },
			success: function (data) {
				$("#get_product").html(data);
			}
		})
	}
	gethomeproduts();
	function gethomeproduts() {
		$.ajax({
			url: "homeaction.php",
			method: "POST",
			data: { gethomeProduct: 1 },
			success: function (data) {
				$("#get_home_product").html(data);
			}
		})
	}
	function producthome() {
		$.ajax({
			url: "homeaction.php",
			method: "POST",
			data: { getProducthome: 1 },
			success: function (data) {
				$("#get_product_home").html(data);
			}
		})
	}


	/*	when page is load successfully then there is a list of categories when user click on category we will get category id and 
		according to id we will show products
	*/
	$("body").delegate(".category", "click", function (event) {
		
		$("#get_product").html("<h3>Loading...</h3>");
		event.preventDefault();
		var cid = $(this).attr('cid');

		$.ajax({
			url: "action.php",
			method: "POST",
			data: { get_seleted_Category: 1, cat_id: cid },
			success: function (data) {
				$("#get_product").html(data);
				if ($("body").width() < 480) {
					$("body").scrollTop(683);
				}
			}
		})

	})
	$("body").delegate(".categoryhome", "click", function (event) {
		event.preventDefault();
		var cid = $(this).attr('cid');
		var currentPage = window.location.pathname.split("/").pop(); 
	
		if (currentPage === "index.php" || currentPage === "product.php" || currentPage ==="payment_success.php" || currentPage ==="cart.php") {
			window.location.href = "store.php";
		} else {
			
			$("#get_product").html("<h3>Loading...</h3>");
			$.ajax({
				url: "homeaction.php",
				method: "POST",
				data: { get_seleted_Category: 1, cat_id: cid },
				success: function (data) {
					$("#get_product").html(data);
					if ($("body").width() < 480) {
						$("body").scrollTop(683);
					}
				}
			});
		}
	});
	




	$("#login").on("submit", function (event) {
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url: "login.php",
			method: "POST",
			data: $("#login").serialize(),
			success: function (data) {
				console.log(data);
				if (data == "login_success") {
					 window.location.href = "index.php";
					 return; // Exit the function
				} else if (data == "cart_login") {
					 window.location.href = "cart.php";
					return; // Exit the function
				} else {
					$("#e_msg").html(data);
					$(".overlay").hide();
				}
			}
		})
	})
	//end

	// Plus button
	$("body").on("click", ".plus-btn", function () {
		let input = $(this).closest(".quantity").find(".qty");
		let value = parseInt(input.val()) || 1;
		if (value < 99) value + 1;
		input.val(value).trigger("keyup"); 
	});

	// Minus button
	$("body").on("click", ".minus-btn", function () {
		let input = $(this).closest(".quantity").find(".qty");
		let value = parseInt(input.val()) || 1;
		if (value > 1) value - 1;
		input.val(value).trigger("keyup"); 
	});


let qtyInputFocused = false;


$("body").on("focus", ".qty", function () {
    qtyInputFocused = true;
});


$("body").on("blur", ".qty", function () {
    qtyInputFocused = false;
});


	$("body").on("keyup change", ".qty", function () {
		let input = $(this);
		let value = parseInt(input.val()) || 1;


		if (value > 99) value = 99;
		if (value < 1) value = 1;

		input.val(value);

		if (qtyInputFocused) {
	
		var update = $(this).closest(".item");
		var update_id = update.find(".update").attr("update_id");
		var qty = update.find(".qty").val();
	
		console.log("Updating product ID: " + update_id + " with quantity: " + qty);
	

		setTimeout(function() {
			$.ajax({
				url: "action.php",
				method: "POST",
				data: { updateCartItem: 1, update_id: update_id, qty: qty },
				success: function (data) {
					$("#cart_msg").html(data);
					checkOutDetails(); 
				}
			});
		}, 500); 
	}
		updateTotals();
	});

	// Plus button
	$("body").on("click", ".plus-btn", function () {
		let input = $(this).closest(".quantity").find(".qty");
		let value = parseInt(input.val()) || 1;

		if (value < 99) value++;
		input.val(value);
		updateTotals();
	});

	// Minus button
	$("body").on("click", ".minus-btn", function () {
		let input = $(this).closest(".quantity").find(".qty");
		let value = parseInt(input.val()) || 1;

		if (value > 1) value--;
		input.val(value);
		updateTotals();
	});

	// Recalculate totals
	function updateTotals() {
		let subtotal = 0;

		$('.qty').each(function () {
			let item = $(this).closest(".item");
			let price = parseFloat(item.find('.price').val()) || 0;
			let qty = parseInt($(this).val()) || 1;

		
			qty = Math.min(Math.max(qty, 1), 99);
			$(this).val(qty);

			let total = price * qty;
			item.find('.total').val(total.toFixed(2));
			subtotal += total;
		});

		let tax = subtotal * 0.06;
		let finalTotal = subtotal + tax;

		$('#subtotal_display').html(subtotal.toFixed(2));
		$('#tax_display').html(tax.toFixed(2));
		$('#total_display').html(finalTotal.toFixed(2));
		$('#total_input').val(finalTotal.toFixed(2));
		$('#totaltax_input').val(tax.toFixed(2));
		$('#stotal_input').val(subtotal.toFixed(2));




	}


	//Get User Information before checkout
	$("#signup_form").on("submit", function (event) {
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url: "register.php",
			method: "POST",
			data: $("#signup_form").serialize(),
			success: function (data) {
				$(".overlay").hide();
				if (data == "register_success") {
					window.location.href = "cart.php";
				} else {
					$("#signup_msg").html(data);
				}

			}
		})
	})


	$("#offer_form").on("submit", function (event) {
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url: "offersmail.php",
			method: "POST",
			data: $("#offer_form").serialize(),
			success: function (data) {
				$(".overlay").hide();
				$("#offer_msg").html(data);

			}
		})
	})



	//Get User Information before checkout end here

	//Add Product into Cart
	$("body").delegate("#product", "click", function (event) {
		var pid = $(this).attr("pid");

		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url: "action.php",
			method: "POST",
			data: { addToCart: 1, proId: pid, },
			success: function (data) {
				count_item();
				getCartItem();
				$('#product_msg').html(data);
				$('.overlay').hide();
			}
		})
	})
	//Add Product into Cart End Here
	//Count user cart items funtion
	count_item();
	function count_item() {
		$.ajax({
			url: "action.php",
			method: "POST",
			data: { count_item: 1 },
			success: function (data) {
				$(".badge").html(data);
			}
		})
	}
	//Count user cart items funtion end

	//Fetch Cart item from Database to dropdown menu
	getCartItem();
	function getCartItem() {
		$.ajax({
			url: "action.php",
			method: "POST",
			data: { Common: 1, getCartItem: 1 },
			success: function (data) {
				$("#cart_product").html(data);
				net_total();

			}
		})
	}

	
	$("body").delegate(".qty", "keyup", function (event) {

	

		event.preventDefault();
		var row = $(this).parent().parent();
		var price = row.find('.price').val();
		var qty = row.find('.qty').val();
		if (isNaN(qty)) {
			qty = 1;
		};
		if (qty < 1) {
			qty = 1;
		};
		var total = price * qty;
		row.find('.total').val(total);
		var net_total = 0;
		$('.total').each(function () {
			net_total += ($(this).val() - 0);
		})
		$('.net_total').html("Total : RM " + net_total);




	})
	//Change Quantity end here 

	/*
		whenever user click on .remove class we will take product id of that row 
		and send it to action.php to perform product removal operation
	*/




	$("body").on("click", ".remove", function (event) {
		var remove_id = $(this).attr("remove_id");

		$.ajax({
			url: "action.php",
			method: "POST",
			data: { removeItemFromCart: 1, rid: remove_id },
			success: function (data) {
				console.log(data); 
				$("#cart_msg").html(data);  
				checkOutDetails();  
			},
			error: function (xhr, status, error) {
				console.log("Error: " + error);  
			}
		});

	});




	/*
		whenever user click on .update class we will take product id of that row 
		and send it to action.php to perform product qty updation operation
	*/
	$("body").delegate(".update", "click", function (event) {
		var update = $(this).closest(".item"); 
		var update_id = update.find(".update").attr("update_id"); 
		var qty = update.find(".qty").val(); 

		console.log("Updating product ID: " + update_id + " with quantity: " + qty); 

		$.ajax({
			url: "action.php",
			method: "POST",
			data: { updateCartItem: 1, update_id: update_id, qty: qty },
			success: function (data) {
				$("#cart_msg").html(data);
				checkOutDetails(); 
			}
		});
	});


	checkOutDetails();
	net_total();

	let canSubmit = false;
	$("body").on("submit", "#checkoutForm", function (event) {

		if (canSubmit === false) {

			event.preventDefault(); 

	
			$(".btnready").prop("disabled", true); 

			let updatedQuantities = [];

			$(".item").each(function () {
				let productId = $(this).find(".update").attr("update_id"); // Product ID
				let quantity = $(this).find(".qty").val(); // Product Quantity

				updatedQuantities.push({ productId: productId, quantity: quantity });
			});

			$.ajax({
				url: "action.php",
				method: "POST",
				data: {
					updateQuantities: 1,
					updatedQuantities: JSON.stringify(updatedQuantities) 
				},
				success: function (data) {
					console.log("Server response: " + data); 

		
					if (data.trim() === "update_success") {
						checkOutDetails();
						net_total();
						console.log("Quantities updated successfully, setting flag to true...");

					
						canSubmit = true;

						$(".btnready").prop("disabled", true);

						if (canSubmit) {
		

							setTimeout(function () {
								$("#submit").click();
							}, 100); 

						}
					} else {
						console.log("Error in update: " + data);
						$("#cart_msg").html(data);

						$(".btnready").prop("disabled", false);
					}
				},
				error: function (xhr, status, error) {
					console.log("AJAX Error: " + error);  

					$(".btnready").prop("disabled", false); 
				}
			});
		}
	});





	
	function checkOutDetails() {
		$('.overlay').show();
		$.ajax({
			url: "action.php",
			method: "POST",
			data: { Common: 1, checkOutDetails: 1 },
			success: function (data) {
				$('.overlay').hide();
				$("#cart_checkout").html(data);
				net_total();
			}
		})
	}
	/*
		net_total function is used to calcuate total amount of cart item
	*/
	function net_total() {
		let net_total = 0;

		$('.qty').each(function () {
			let item = $(this).closest(".item"); 
			let price = parseFloat(item.find('.price').val()) || 0;
			let qty = parseInt($(this).val()) || 1;


			qty = Math.min(Math.max(qty, 1), 99);
			$(this).val(qty);

			let total = price * qty;
			item.find('.total').val(total.toFixed(2));
			net_total += total;
		});

		let tax = net_total * 0.06;
		let finalTotal = net_total + tax;

		$('#subtotal_display').html(net_total.toFixed(2));
		$('#tax_display').html(tax.toFixed(2));
		$('#total_display').html(finalTotal.toFixed(2));
		$('#total_input').val(finalTotal.toFixed(2));
		$('#totaltax_input').val(tax.toFixed(2));
		$('#stotal_input').val(net_total.toFixed(2));
	}



	//remove product from cart

	page();
	function page() {
		$.ajax({
			url: "action.php",
			method: "POST",
			data: { page: 1 },
			success: function (data) {
				$("#pageno").html(data);
			}
		})
	}
	$("body").delegate("#page", "click", function () {
		var pn = $(this).attr("page");
		$.ajax({
			url: "action.php",
			method: "POST",
			data: { getProduct: 1, setPage: 1, pageNumber: pn },
			success: function (data) {
				$("#get_product").html(data);
			}
		})
	})
})




















