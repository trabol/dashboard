<div class="row">
			<!-- Profile Info and Notifications -->
			<div class="col-md-6 col-sm-8 clearfix">
				<ul class="user-info pull-left pull-none-xsm">
					<li class="profile-info dropdown"><!-- add class "pull-right" if you want to place this from right -->
					 	<?php  if(isset($_SESSION['SE_NOMBRE'])){?>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="<?php echo base_url();?>assets/images/logo/perfil_csc.png" alt="" class="img-circle" width="44" />
							<?php echo $_SESSION["SE_NOMBRE"]." ".$_SESSION["SE_APELLIDO"];?> 
						</a>
						<?php }?>

					</li>
				</ul>
			</div>
			<!-- Raw Links -->
			<div class="col-md-6 col-sm-4 clearfix hidden-xs">
				<ul class="list-inline links-list pull-right">
					<li class="sep"></li>
					<li>
						<a href="<?php echo base_url();?>logout" style="color:white!important;">
							<button class="btn btn-success">Log Out <i class="entypo-logout right"></i></button>
						</a>
					</li>
				</ul>
		
			</div>
		
		</div>