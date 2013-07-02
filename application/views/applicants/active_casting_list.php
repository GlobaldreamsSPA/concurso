<script type="text/javascript">
	$(function() {
		$( ".accordion" ).accordion();
	});
</script>

<div class="row">		
  	<div class="span3 user-profile-left top-div-left">
		<div class="row top-title-left" >
			<h1>Perfil</h1>
		</div>


		<div class="row">
    		<div style="padding-left: 3%;" class="span10 offset1">
    			<div style="text-align:center;">
					<?php 


						if(file_exists(APPPATH.'/../img/gallery/'.$image_profile_name) == TRUE)
							echo "<img class='user_image' src='".HOME.'/img/gallery/'.$image_profile_name."'/>";
						else
							echo "<img class='user_image' src='".HOME."/img/profile/user.jpg'/>";
						


					?>
				</div>
				<div class="space2"></div>


    			<ul class="nav nav-pills nav-stacked">
					<li class="active"><a> <i class="icon-th-large"></i> Postulaciones Activas</a></li>											
					<li><a href="<?php echo HOME.'/user/results_casting'?>"> <i class=" icon-star"></i> Resultados de Concursos</a></li>											
					<li><a href="<?php echo HOME."/user/edit/".$user_id;?>"> <i class="icon-edit"></i> Editar Datos</a></li>	
					<li><a href="<?php echo HOME."/user/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
				</ul>
			</div>
		</div>
	</div>
	
    <div  class="span9 user-profile-right top-div-right">
    	
    	<div class="row top-title" >
			<h1>Postulaciones Activas a Concursos</h1>
		</div>

		<div class="space1">
		</div>

		<?php 							
		if(isset($castings))
			foreach($castings as $casting){ ?>
			
				<div class="row">
					<div style="margin-left:3%;" class="span1">
						<img src="<?php echo $casting['logo'] ?>"/>
					</div>
					<div style="margin-top: 1.5%;"class="span5">
						<h4><?php echo $casting['title'] ?></h4>
					</div>
					<div style="margin-top: 2%; font-size: 15px;" class="span2 offset1">
						<span class="fui-time"></span> <?php echo $casting['days'] ?> d&iacute;as
					</div>
					<div class="span1 offset1" style="margin-top:1%;" >
						<a class="btn" style="color:white; background: #e67e22;" href="mailto:contacto@viddon.com">
							<span class="fui-mail"></span>                                            
						</a>
					</div>
					
					<div class="span1" style="margin-top:1%;">
						<form action="" method="POST">
							<button style="color:white; background: #e67e22;" class="btn" type="submit">
								<span class="fui-cross"></span>
							</button>
							<input type="hidden" name="del-apply" value="<?php echo $casting["apply_id"] ?>"/>
						</form>										
					</div>
					
				</div>
				
				<div class="row">
					<div style="margin-left:3%;" class="span6">
						<div class="space05"></div>
						<img style='height:100%; width: 100%;' src="<?php echo $casting['image'] ?>"/>
					</div>
					<div style="padding-left: 1%; margin-left:5%;" class="span5 offset1 list-view-applies-desc">
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
