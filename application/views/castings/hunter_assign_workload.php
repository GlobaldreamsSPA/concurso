<div class="row-fluid">		
	<div class="span3 user-profile-left">
		<img class='user_image' src="<?php echo HOME."/img/logo_hunter/".$user_data['logo'] ?>"/>
		<div class="space4"></div>
		
		<div class="span9 offset1">
    		<ul class="nav nav-pills nav-stacked orange">
			  	<li><a href="<?php echo HOME."/hunter";?>"> <i class="icon-user"></i> Perfil</a> </li>
				<li><a href="<?php echo HOME."/hunter/edit/";?>"> <i class="icon-pencil"></i> Editar Datos</a></li>
				<li class="active"><a> <i class="icon-list-alt"></i> Gesti&oacute;n Hunters</a></li>
				<li><a href="<?php echo HOME."/hunter/publish";?>"> <i class="icon-edit"></i> Nuevo Casting</a></li>
				<li><a href="<?php echo HOME."/hunter/casting_list";?>"> <i class="icon-list"></i> Mis Castings</a></li>
				<li><a href="<?php echo HOME."/hunter/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
			</ul>
		</div>
	</div>
    
    <div class="span8 offset1 user-profile-right">
    		
		<row>								
			<h3 class="profile-title">Gestor Hunters/ Hunter / Asignar Trabajo</h3>
			<legend>
			</legend>								
		</row>
		
		<table id="datatables" class="table">
          <thead>
            <tr>
              <th>Casting</th>
              <th>Libre</th>
              <th>Cantidad</th>
              <th>Refactorizar</th>
              <th>Acci&oacuten</th>
            </tr>
          </thead>
          <tbody>
          	
          	<?php
          	 if(isset($castings))
	          	 foreach ($castings as $casting) {?>
					<tr>
			            <td style="vertical-align:middle;"><?php echo $casting["casting_name"]?></td>
		                <td style="vertical-align:middle;">
		                	<?php echo $casting["quantity"]?>
			    		</td>
		                <td >
		                	<input style="margin-top: 5px; width: 100%;"type="text" name="quantity" value="<?php echo $casting["default"]?>">
		                </td>
		                <td style="vertical-align:middle; text-align:center;">
		                	<input type="checkbox" id="field1" class="mycheckbox" />
		                </td>
			            <td  style="vertical-align:middle;" class="row center">
				            <div title="Ver Trabajo Hunter" class="span4">
								<a class="btn" href="">
									Asignar                                           
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