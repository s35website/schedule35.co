<nav class="navbar navbar-light navbar-glass fs--1 row navbar-top sticky-kit navbar-expand">
	<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
	
	<a class="navbar-brand text-left d-xl-block" href="<?php echo AMBASSURL; ?>" style="display: none;">
	  <div class="d-flex align-items-center">
	  	<div class="logo-wrapper">
	  		<img class="logo" src="<?php echo UPLOADURL; ?>logo-alt-black.svg" alt="<?php echo $core->site_name; ?>">
	  	</div>
	  	<span class="text-sans-serif">Ambassador Program (Beta)</span>
	  </div>
	</a>
	
	<div class="collapse navbar-collapse" id="navbarNavDropdown1"> 
	  <ul class="navbar-nav align-items-center ml-auto">
	    <li class="nav-item dropdown">
			<a class="nav-link px-0" href="<?php echo SITEURL; ?>/shop" target="_blank">
				<span class="fas fa-cart-plus fs-4" data-fa-transform="shrink-7"></span>
			</a>
		</li>
	    <li class="nav-item dropdown"><a class="nav-link pr-0" id="navbarDropdownUser" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	        <div class="avatar avatar-xl">
	          <img class="rounded-circle" src="<?php echo THEMEURL;?>/assets/img/icons/avatar-img.png" alt="" />
	
	        </div>
	      </a>
	      <div class="dropdown-menu dropdown-menu-right py-0" aria-labelledby="navbarDropdownUser">
	        <div class="bg-white rounded-soft py-2">
	          <a class="dropdown-item font-weight-bold text-warning" href="<?php echo AMBASSURL; ?>/program"><span class="fas fa-crown mr-1"></span><span><?php echo $urow->invite_code;?></span></a>
	
	          <div class="dropdown-divider"></div>
	          <a class="dropdown-item" href="<?php echo AMBASSURL; ?>">Dashboard</a>
	          <a class="dropdown-item" href="<?php echo AMBASSURL; ?>/history">History</a>
			  <a class="dropdown-item" href="<?php echo AMBASSURL; ?>/account">Account Settings</a>
	
	          <div class="dropdown-divider"></div>
	          <a class="dropdown-item" href="<?php echo AMBASSURL; ?>/logout">Logout</a>
	        </div>
	      </div>
	    </li>
	  </ul>
	</div>
</nav>