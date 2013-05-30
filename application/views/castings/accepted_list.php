	<div class="row-fluid">		
	<div class="span3 user-profile-left">
		<img class='user_image' src="<?php echo HOME."/img/logo_hunter/".$user_data['logo'] ?>"/>
		<div class="space4"></div>
		
		<div class="span9 offset1">
    		<ul class="nav nav-pills nav-stacked orange">
			  	<li><a href="<?php echo HOME."/hunter";?>"> <i class="icon-user"></i> Perfil</a> </li>
				<li><a href="<?php echo HOME."/hunter/edit/";?>"> <i class="icon-pencil"></i> Editar Datos</a></li>
				<li><a href="<?php echo HOME."/hunter/manage_hunters/";?>"> <i class="icon-list-alt"></i> Gesti&oacute;n Hunters</a></li>
				<li><a href="<?php echo HOME."/hunter/publish";?>"> <i class="icon-edit"></i> Nuevo Casting</a></li>
				<li class="active"><a> <i class="icon-list"></i> Mis Castings</a></li>
				<li><a href="<?php echo HOME."/hunter/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
			</ul>
		</div>
	</div>
    
    <div class="span8 offset1 user-profile-right">
    		
		<row>								
			<div class="span10"> 
				<h3 class="profile-title"><a href="<?php echo HOME.'/hunter/casting_list' ?>">Castings/</a><a href="<?php echo HOME.'/hunter/casting_detail/'.$id_casting ?>"><?php echo $name_casting."/"; ?></a> Seleccionados </h3>
			</div>
			<div class="span2">
				<a class="btn" href="<?php echo "mailto: ".$mailto_all; ?>">
					<i class="icon-envelope"></i>
					Todos                                            
				</a>
			</div>	
			<legend>
			</legend>								
		</row>
		
		<table id="datatables" class="table">
          <thead>
            <tr>
              <th>Imagen</th>
              <th>Nombre</th>
              <th>Observaciones</th>
              <th>Acci&oacuten</th>
            </tr>
          </thead>
          <tbody>
          	
          	<?php
          	 if(isset($applicants))
	          	 foreach ($applicants as $applicant) {?>
					<tr>
			            <td style="vertical-align:middle;">
			            	<img style="max-width: 80px; max-height:80px;" src="<?php echo HOME."/img/gallery/".$applicant["image_profile"] ?>"/>
			    		</td>
			            <td style="vertical-align:middle;"><?php echo $applicant["name"]?></td>
			            <td style="vertical-align:middle;"><?php echo $applicant["observation"]?></td>
			            <td  style="vertical-align:middle;" class="row center">
				            <div class="span6">
								<a class="btn" target="_blank" href="<?php echo HOME."/user/index/".$applicant["id"]; ?>">
									<i class="icon-zoom-in"></i>                                            
								</a>
							</div>
							<div class="span6">
								<a class="btn" href="<?php echo "mailto:".$applicant["email"] ?>">
									<i class="icon-envelope"></i>                                            
								</a>
							</div>
						</td>
		            </tr>    
              	<?php }?>
          </tbody>
        </table>
		
	</div>
</div>
<div class="row-fluid">	
	<div class="space4"></div>	
</div>