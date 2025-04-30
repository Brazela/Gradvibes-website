<?php
if (isset($_POST["login_user_with_product"])) {
	$product_list = $_POST["product_id"];
	$json_e = json_encode($product_list);
	setcookie("product_list", $json_e, strtotime("+1 day"), "/", "", "", TRUE);

}
?>

<div class="wait overlay">
	<div class="loader"></div>
</div>
<div class="container-fluid">
	<!-- row -->


	<div class="login-marg">
		<!-- Billing Details -->


		<!-- /Billing Details -->


		<form onsubmit="return false" id="login" class="login100-form ">
			<div class="billing-details jumbotron">
				<div class="section-title">
					<h2 class="login100-form-title p-b-49">Login</h2>
				</div>

				<div class="errorlogin" id="e_msg"></div>

				<div class="form-group">
					<input class="input input-borders" type="email" name="email" placeholder="Email"
						 id="password" required>
				</div>

				<div class="form-group">
					<input class="input input-borders" type="password" name="password" placeholder="Password"
						 id="password" required>
				</div>

				<br>

				<input class="primary-btn btn-block" type="submit" Value="Login"><br><br>
				<div class="text-center mt-3">
					Don't have an account?
					<a href="#" onclick="switchToRegister()">Register here</a>
				</div>

				<script>
					function switchToRegister() {
						$('#Modal_login').modal('hide');     
						setTimeout(function () {
							$('#Modal_register').modal('show');
						}, 450);
					}
				</script>

			</div>

		</form>

		<!-- Shiping Details -->

		<!-- /Shiping Details -->

		<!-- Order notes -->

		<!-- /Order notes -->
	</div>

	<!-- Order Details -->

	<!-- /Order Details -->

	<!-- /row -->
</div>