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
    		<div style="padding-left:5%; padding-right:1%;"class="span10">
    			<ul class="nav nav-pills nav-stacked">
					<li><a href="<?php echo HOME.'/user'?>"> <i class="icon-th-large"></i> Postulaciones Activas</a></li>											
					<li class="active"><a> <i class=" icon-star"></i> Resultados de Concursos</a></li>											
					<li><a href="<?php echo HOME."/user/edit/".$user_id;?>"> <i class="icon-edit"></i> Editar Datos</a></li>	
					<li><a href="<?php echo HOME."/user/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
				</ul>
			</div>
		</div>
	</div>
    <div class="span8 offset1 user-profile-right">
    		
		<legend> <h1>Resultados de Postulaciones a Concursos</h1></legend>
		<table id="datatables" class="table">
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
		<div class="space4"></div>	
		<div class="space4"></div>						
	</div>					
</div>			