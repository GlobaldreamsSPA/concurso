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
					<li><a href="<?php echo HOME.'/user'?>"> <i class="icon-th-large"></i> Postulaciones Activas</a></li>											
					<li class="active"><a> <i class=" icon-star"></i> Resultados de Concursos</a></li>											
					<li><a href="<?php echo HOME."/user/edit/";?>"> <i class="icon-edit"></i> Editar Datos</a></li>	
					<li><a href="<?php echo HOME."/user/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
				</ul>
			</div>
		</div>
	</div>


    <div class="span9 user-profile-right top-div-right"> 	
    	<div class="row top-title" >
			<h1>Resultados de Postulaciones a Concursos</h1>		
		</div>

		<div class="space2"></div>
		<div class="space1"></div>
		<div style="padding-right:4%; !important">
			<table class="table">
	          <thead>
	            <tr>
	              <th>Fecha</th>
	              <th>Nombre</th>
	              <th>Estado</th>
	              <th>Acci&oacuten</th>
	            </tr>
	          </thead>
	          <tbody>
	            
	            <?php 
	            	if(isset($castings))
	            		foreach ($castings as $casting) {
							
						?>
							<tr>
			                  <td>21/02/2013</td>
			                  <td><?php echo $casting["title"] ?></td>
			                  <td><span class="label label-warning"><?php echo $casting["apply_status"] ?></span></td>
			                  <td class="center ">
								<a class="btn" href="#">
									<i class="icon-zoom-in"></i>                                            
								</a>
								<a class="btn" href="#">
									<i class="icon-envelope"></i>                                            
								</a>
							  </td>
			                </tr>
	            <?php	} ?>
	           </tbody>
	        </table>
   		</div>
		<div class="space4"></div>	
		<div class="space4"></div>						
	</div>					
</div>			