<div class="row-fluid">		
	<div class="span3 user-profile-left">
		<div class="row">
		<?php 
			echo "<a href= '".HOME."/user/photo_gallery/'>";
			
			if(file_exists(APPPATH.'/../img/gallery/'.$image_profile_name) == TRUE)
				echo "<img class='user_image' src='".HOME.'/img/gallery/'.$image_profile_name."'/>";
			else
				echo "<img class='user_image' src='".HOME."/img/profile/user.jpg'/>";
			
			echo "</a>";

		?>
		</div>
		<div class="space2"></div>
		<div class="row">
			<?php if(!$public) {?>
			<form action="" method="POST">
				<?php if($postulation_flag) {?>
				<a href="<?php echo HOME.'/home/casting_list'?>" class="btn btn-success" type="submit" name="apply">POSTULAR CASTINGS</a>
				<input type="hidden" name="validate" value="1"/>
				<?php } else{ ?>
				<button data-toggle="modal"  href="#error" class="btn btn-success">POSTULAR CASTINGS</button>
    			<?php } ?>
    		</form>
    		<?php } ?>
		</div>
		<div class="row">
    		<div class="span10 offset1">
    			<ul class="nav nav-pills nav-stacked orange">
					<li><a  href="<?php echo HOME."/user"?>"> <i class="icon-user"></i> Perfil</a>
					</li>
					<li><a href="<?php echo HOME."/user/edit/".$user_id;?>"> <i class="icon-pencil"></i> Editar Datos</a></li>
					<li>
						<a data-toggle="collapse" href="#collapseOne">
							<i class="icon-star-empty"></i> Postulaciones
						</a>
						<div id="collapseOne" class="collapse in">
							<ul style="padding-left: 30px;" class="nav nav-pills nav-stacked orange">
								<li><a href="<?php echo HOME."/user/active_casting_list"?>">Activas</a></li>	
								<li class="active"><a>Resultados</a></li>	
							</ul>
						</div>
					</li>	
					<li><a href="<?php echo HOME."/user/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
				</ul>
			</div>
		</div>
	</div>

    <div class="span8 offset1 user-profile-right">
    		
		<legend> <h2>Resultados Postulaciones</h2></legend>
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