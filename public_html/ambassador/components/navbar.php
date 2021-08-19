<nav class="navbar navbar-vertical navbar-expand-xl navbar-light navbar-glass">
	<!--<a class="navbar-brand text-left" href="<?php echo AMBASSURL; ?>">
		<div class="d-flex align-items-center py-3">
			<div class="logo-wrapper">
				<img class="logo" src="<?php echo UPLOADURL; ?>logo-alt-black.svg" alt="<?php echo $core->site_name; ?>">
			</div>
			<span class="text-sans-serif">AP (Beta)</span>
		</div>
	</a>-->
	<div class="collapse navbar-collapse" id="navbarVerticalCollapse">
		<ul class="navbar-nav flex-column">
			<li class="nav-item">
				<a class="nav-link" href="<?php echo AMBASSURL; ?>">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-chart-pie"></span>
						</span>
						<span>Dashboard</span>
					</div>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo AMBASSURL; ?>/orders">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-cart-plus"></span>
						</span>
						<span>Orders</span>
					</div>
				</a>
			</li>
			
			<li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#pages" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="pages">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-copy"></span>
						</span>
						<span>Reports</span>
					</div>
				</a>
				<ul class="nav collapse" id="pages" data-parent="#navbarVerticalCollapse">
					<li class="nav-item">
						<a class="nav-link" href="<?php echo AMBASSURL; ?>/report-earning">Earning Report</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo AMBASSURL; ?>/report-order">Order Report</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo AMBASSURL; ?>/report-monthly">Monthly Visitor</a>
					</li>
				</ul>
			</li>
			
			<li class="nav-item">
				<a class="nav-link" href="<?php echo AMBASSURL; ?>/account">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-user-circle"></span>
						</span>
						<span>Account</span>
					</div>
				</a>
			</li>
			
		</ul>
	</div>
</nav>