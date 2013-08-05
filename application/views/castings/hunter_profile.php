<div style="margin-left: -3%;" class="span3">
	<div style=" padding-right: 10%; padding-left:10%; border-top-left-radius:10px; border-top-right-radius: 10px;" class="row-fluid">
		<div style="margin-left:-10% !important; margin-right: -11%;" class="row top-title-left" >
			<h1>Perfil</h1>
		</div>
		<img class='user_image' src="<?php echo HOME."/img/logo_hunter/".$user_data['logo'] ?>"/>
		<div class="space4"></div>
		
		<div class="span9 offset1">
	    	<ul class="nav nav-pills nav-stacked orange">
				<li class="active"><a> <i class="icon-user"></i> Perfil</a></li>
			 	<li><a href="<?php echo HOME."/hunter/edit/";?>"> <i class="icon-pencil"></i> Editar Datos</a></li>
			 	<li><a href="<?php echo HOME."/hunter/publish";?>"> <i class="icon-edit"></i> Nuevo Concurso</a></li>
			 	<li><a href="<?php echo HOME."/hunter/casting_list";?>"> <i class="icon-list"></i> Mis Concursos</a></li>
				<li><a href="<?php echo HOME."/hunter/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
			</ul>
		</div>
	</div>
</div>

<div style="margin-left:6.5%;" class="span9">
	<div style="padding-left:4%; padding-right:6%; border-top-left-radius:10px; border-top-right-radius: 10px;" class="row-fluid">		
		<div style="margin-left:-4% !important; margin-right: -6%;" class="row top-title-left" >
			<h1><?php echo $user_data['name'] ?></h1>					
		</div>
		
		<div class="space4"></div>
		<div style="font-size: 20px; text-align: justify; line-height: 25px;"><?php echo $user_data['about_us'] ?></div>
		<div class="space4"></div>
			
		<legend>Nuestros Concursos</legend>
		<div class="row">
			<div style="margin-left:10%; margin-top:30px; height: 350px; width: 80%;" id="myCarousel" class="carousel slide">
			<!-- Carousel items -->
				<div class="carousel-inner">
					<?php 
					$flag = true;
					foreach($castings as $casting){ 

						if($flag)
						{
					?>
					   		<div class="active item">
				    <?php 
					
						}
						else
						{
					?>
							<div class="item">
					<?php 
						}
						$flag=false;
					?>
						<img style="width:100%; max-height:100%;" id="image_casting" src=<?php echo $casting['image']?> >
					</div>
					<?php } ?>
			  	</div>
				<!-- Carousel nav -->
				<a style="margin-top:5%; margin-left: 10px;" class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
				<a style="margin-top:5%;" class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
			</div>
		</div>
		<div class="row">			
			<a  class="btn btn-info" style="float: right;" href="<?php echo HOME."/hunter/casting_list";?>"> Ver todos mis concursos</a>
		</div>
		<div class="space1"></div>	
	</div>
</div>