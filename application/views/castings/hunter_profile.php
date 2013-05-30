	  				<div class="row-fluid">		
				    	<div class="span3 user-profile-left">
				    		<img class='user_image' src="<?php echo HOME."/img/logo_hunter/".$user_data['logo'] ?>"/>
				    		<div class="space4"></div>
				    		
				    		<div class="span9 offset1">
					    		<ul class="nav nav-pills nav-stacked orange">
									<li class="active"><a> <i class="icon-user"></i> Perfil</a></li>
								 	<li><a href="<?php echo HOME."/hunter/edit/";?>"> <i class="icon-pencil"></i> Editar Datos</a></li>
									<li><a href="<?php echo HOME."/hunter/manage_hunters/";?>"> <i class="icon-list-alt"></i> Gesti&oacute;n Hunters</a></li>
								 	<li><a href="<?php echo HOME."/hunter/publish";?>"> <i class="icon-edit"></i> Nuevo Casting</a></li>
								 	<li><a href="<?php echo HOME."/hunter/casting_list";?>"> <i class="icon-list"></i> Mis Castings</a></li>
									<li><a href="<?php echo HOME."/hunter/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
								</ul>
							</div>
				    	</div>
					    
					    <div class="span8 offset1 user-profile-right">
					    		
					    	<div class="space1"></div>
					    	<h2 class="profile-title"><?php echo $user_data['name'] ?></h2> 
							<div class="space1"></div>
							<h3 id="profile">Nosotros</h3>
							<div class="justify profile-content"><?php echo $user_data['about_us'] ?></div>
							<div class="space4"></div>
							<h3 id="profile">Buscamos</h3>
							<div class="justify profile-content"><?php echo $user_data['we_look_for'] ?></div>
							<div class="space1"></div>
								
							<legend>Nuestros Castings</legend>
							
							<div style="margin-left:10%; margin-top:30px; height: 250px; width: 80%;" id="myCarousel" class="carousel slide">
							<!-- Carousel items -->
								<div class="carousel-inner">
									<?php foreach($castings as $casting){ ?>
								    <div class="active item">
										<img style="width:100%; height:100%;" id="image_casting" src=<?php echo $casting['image']?> >
									</div>
									<?php } ?>
							  	</div>
								<!-- Carousel nav -->
								<a style="margin-top:5%; margin-left: 10px;" class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
								<a style="margin-top:5%;" class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
							</div>
							
							<div class="space2"></div>	
							
							<a  class="MBT-readmore" style="float: right;" href="<?php echo HOME."/hunter/casting_list";?>"> Ver Todos Los Castings >></a>
						</div>
					</div>