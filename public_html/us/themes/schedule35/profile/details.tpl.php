<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php include ("nav-profile.tpl.php"); ?>
<div id="profile-details" class="wrapper padded bg-lightgrey">

	<div class="container page details">
	
		<h2 class="t0 p60 text-center">Account Details</h2>
		
		<?php include ("nav-profile-account.tpl.php"); ?>
		
		<!-- Masta -->
		<div class="form-validetta masta" id="details_name">
			<div class="tab view">
				<h2>Name</h2>
				
				<span class="view-display name" id="dis_fullname"><?php echo $urow->fname;?> <?php echo $urow->lname;?></span>
	
				<div class="right table">
					<div class="middle">
						<span class="link edit">Edit</span>
						<span class="link cancel">Cancel</span>
					</div>
				</div>
			</div>
			<div class="form view grid t30neg">
			
				<div class="row">
					<div class="col-sm-6">
						<label for="fname" class="for-ie">First Name</label>
						<input type="text" id="fname" name="fname" placeholder="First Name" value="<?php echo $urow->fname;?>" data-validetta="required,minLength[2]">
					</div>
		
					<div class="col-sm-6">
						<label for="lname" class="for-ie">Last Name</label>
						<input type="text" id="lname" name="lname" placeholder="Last Name" value="<?php echo $urow->lname;?>" data-validetta="minLength[2]">
					</div>
					
				</div>
	
				<a data-name="details_name" data-id="<?php echo $urow->id;?>" class="updateName btn primary med t12">
					Save Changes
				</a>
				
			</div>
			
		</div>
		
		<!-- Masta -->
		<div class="form-validetta masta" id="details_email">
			<div class="tab view">
				<h2>Email Address</h2>
				<span class="view-display email" id="dis_email"><?php echo $urow->username;?></span>
	
				<div class="right table">
					<div class="middle">
						<span class="link edit">Edit</span>
						<span class="link cancel">Cancel</span>
					</div>
				</div>
			</div>
			<div class="form view t30neg">
			
				<div class="row">
						
					<div class="col-sm-11">
						<label for="email" class="for-ie">Email</label>
						<input type="email" id="email" name="email" placeholder="Email" value="<?php echo $urow->username;?>">
					</div>
					
				</div>
				
				<a data-name="details_email" data-id="<?php echo $urow->id;?>" class="updateEmail btn primary med t12">
					Save Changes
				</a>
			</div>
		</div>
		
		<!-- Masta -->
		<div class="form-validetta masta" id="details_password">
			<div class="tab view">
				<h2>Password</h2>
				<span class="view-display password">xxxxxxxxx</span>
	
				<div class="right table">
					<div class="middle">
						<span class="link edit">Edit</span>
						<span class="link cancel">Cancel</span>
					</div>
				</div>
			</div>
			<div class="form view t30neg">
			
				<div class="row">
						
					<div class="col-sm-11">
						<label for="verifyPW" class="for-ie">Current Password</label>
						<input type="password" id="verifyPW" name="verifyPW" class="password-field" placeholder="Current Password">
						
						<label for="newPW" class="for-ie">Password</label>
						<input type="password" id="newPW" name="newPW" class="password-field" placeholder="New Password">
						
						<label for="confirmPW" class="for-ie">New Password (Optional)</label>
						<input type="password" id="confirmPW" name="confirmPW" class="password-field" placeholder="Confirm Password">
					</div>
					
				</div>
				
				<a data-name="details_password" data-id="<?php echo $urow->id;?>" class="updatePassword btn primary med t12">
					Save Changes
				</a>
				
			</div>
		</div>
		
		<!-- Masta -->
		<div class="form-validetta masta" id="details_shipping">
			<div class="tab view">
				<h2>Shipping Information</h2>
				
				<p class="view-display" id="display_shippinginfo">
				
					
					
					<span id="dis_address2">
						<?php 
							if ($urow->address2) {
								echo('#'. $urow->address2 . ' - ');
							}
						 ?>
					</span>
					<span id="dis_address">
						<?php 
							if ($urow->address) {
								echo($urow->address);
							}
							else {
								echo('<em>Enter shipping information for faster checkout.</em>');
							}
						 ?>
					</span>
					
					<?php if($urow->city):?>
					<br/>
					<span id="dis_city"><?php echo $urow->city?></span>,
					<span id="dis_state"><?php echo $urow->state?></span>
					<span id="dis_zip"><?php echo $urow->zip?></span>
					<?php else:?>
					<span id="dis_city"></span>,
					<span id="dis_state"></span>
					<span id="dis_zip"></span>
					<?php endif;?>
				</p>
				
				<div class="right table">
					<div class="middle">
						<span class="link edit">Edit</span>
						<span class="link cancel">Cancel</span>
					</div>
				</div>
			</div>
			<div class="form view t60neg">
			
				<div class="form address grid">
					<form method="post" id="form-validetta-shipping" data-id="<?php echo $urow->id;?>" data-name="details_shipping">
						
						
						
						<div class="form-group p0">
							<div class="row">
								<div class="toggle country col-sm-12">
									<div>
										<input type="radio" name="country" value="CA" id="country_ca" disabled>
										<label for="country_ca" class="ca"><span class="img"></span> Canada</label>
									</div>
									<div class="country_error">
										<input type="radio" name="country" value="US" id="country_us" checked>
										<label for="country_us" class="us"><span class="img"></span> United States</label>
									</div>
								</div>
							</div>
						</div>
						
						
						<div class="form-group p0">
							<div class="row">
								<div class="col-sm-12">
									<label for="fullname">Full Name</label>
									<input class="required" type="text" id="fullname" name="fullname" placeholder="Name" value="<?php echo $urow->fullname_shipping;?>" data-validetta="required,minLength[2]">
								</div>
							</div>
						</div>
						
						<div class="form-group p0">
							<div class="row">
								<div class="col-sm-12 col-md-8">
									<label for="address_line_1">Address</label>
									<input class="required" id="address_line_1" type="text" placeholder="Address" name="address_line_1" maxlength="30" value="<?php echo $urow->address?>" data-validetta="required,minLength[5]">
								</div>
				
								<div class="col-sm-12 col-md-4">
									<label for="address_line_2">Apt / Suite #</label>
									<input id="address_line_2" type="text" placeholder="Apt / Suite #" name="address_line_2" maxlength="255" value="<?php echo $urow->address2?>">
								</div>
							</div>
						</div>



						<div class="form-group p0">
							<div class="row">
								<div class="col-sm-12 col-md-4">
									<label for="city">City</label>
									<input class="required" id="city" type="text" placeholder="City" name="city" maxlength="255" value="<?php echo $urow->city?>" data-validetta="required,minLength[2]">
								</div>
								
								<div class="col-6 col-md-4">
									<label for="state">State</label>
									<select id="state" name="state" class="state">
										<option value="" disabled selected></option>
										
										<?php $provRow = $content->getProvinces(); ?>
										<?php foreach ($provRow as $prrow): ?>
										<option value="<?php echo($prrow->abbr); ?>" data-cost="<?php echo($prrow->shipping_cost); ?>" <?php echo $urow->state == $prrow->abbr ? 'selected' : ''?>><?php echo($prrow->abbr); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
				
								<div class="col-6 col-md-4">
									<label for="zip">Zip/Postal</label>
									<input class="required" id="zip" type="text" value="<?php echo $urow->zip;?>" placeholder="Zip Code" name="zip" maxlength="11" data-validetta="required,minLength[2]">
								</div>
							</div>
						</div>
						
						
						<div class="form-group p18">
							<div class="row">
								<div class="col-sm-12">
									<label for="telephone">Telephone (Optional)</label>
									<input class="last-input" id="telephone" type="number" value="<?php echo $urow->phone;?>" placeholder="Telephone (Optional)" name="phone" maxlength="20" >
								</div>
							</div>
						</div>
						
						
						
						<button data-name="details_shipping" type="submit" data-id="<?php echo $urow->id;?>" class="updateShipping btn primary med t12">
							Save Changes
						</button>
						
					</form>
				</div>
				
			</div>
		</div>
		
		
	</div>
	
</div>