<script type="text/javascript">
	$(function() {
		$( ".accordion" ).accordion();
	});
</script>

<div class="row-fluid">		
  	<div class="span3 user-profile-left">
		<div class="row">
		<?php 


			if(file_exists(APPPATH.'/../img/gallery/'.$image_profile_name) == TRUE)
				echo "<img class='user_image' src='".HOME.'/img/gallery/'.$image_profile_name."'/>";
			else
				echo "<img class='user_image' src='".HOME."/img/profile/user.jpg'/>";
			


		?>
		</div>
		<div class="space2"></div>
		<div class="row">
    		<div class="span10">
    			<ul class="nav nav-pills nav-stacked">
					<li class="active"><a> <i class="icon-th-large"></i> Postulaciones Activas</a></li>											
					<li><a href="<?php echo HOME.'/user/results_casting'?>"> <i class=" icon-star"></i> Resultados de Concursos</a></li>											
					<li><a href="<?php echo HOME."/user/edit/".$user_id;?>"> <i class="icon-edit"></i> Editar Datos</a></li>	
					<li><a href="<?php echo HOME."/user/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
				</ul>
			</div>
		</div>
	</div>
	


    <div class="span8 offset1 user-profile-right">
    	
			<h1>Postulaciones Activas a Concursos</h1>

		<?php 							
		if(isset($castings))
			foreach($castings as $casting){ ?>
			
				<div class="row">
					<div class="span1">
						<img src="<?php echo $casting['logo'] ?>"/>
					</div>
					<div class="span5">
						<h4><?php echo $casting['title'] ?></h4>
					</div>
					<div style="margin-top:2%;" class="span3">
						<i class="icon-time"></i> <?php echo $casting['days'] ?> d&iacute;as
					</div>
					<div class="span1">
						<a class="btn" href="mailto:contacto@viddon.com">
							<i class="icon-envelope"></i>                                            
						</a>
					</div>
					
					<div class="span1">
						<form action="" method="POST">
							<button class="btn" type="submit"><i class="icon-remove"></i></button>
							<input type="hidden" name="del-apply" value="<?php echo $casting["apply_id"] ?>"/>
						</form>										
					</div>
					
				</div>
				
				<div class="row">
					<div class="span6">
						<div class="space05"></div>
						<img style='height:100%; width: 100%;' src="<?php echo $casting['image'] ?>"/>
					</div>
					<div style="padding-left: 1%;" class="span6 list-view-applies-desc">
						<div class="space05"></div>
						<div class="row accordion">
							<h3>Descripci&oacuten</h3>
							<div style="font-size:12px;">
								<?php echo  $casting['description']; ?>
							</div>
							<h3>Pasos del Concurso</h3>
							<div style="font-size:12px;">
								<?php echo  $casting['steps']; ?>
							</div>
							<h3>Bases</h3>
							<div style="font-size:12px;">
								<?php echo  $casting['bases']; ?>
							</div>
							<h3>Premios</h3>
							<div style="font-size:12px;">
								<?php echo  $casting['prizes_description']; ?>
							</div>
						</div>							
					</div>
				</div>
				
				<div class="space4"></div>
			
			
		<?php } ?>
	
		
	
		
		<div class="space4"></div>	
		<div class="space4"></div>						
	</div>					
</div>
