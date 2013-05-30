<div id="edit_workload" class="modal hide fade" style="width: 350px !important;" tabindex="-1" role="dialog" aria-hidden="true">					
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Editar Carga</h3>
	</div>
	<div class="modal-body">
			<div style="text-align:center">	
				<label> Cantidad Antigua sin revisar: 90000</label>
				<input name="Cantidad" style="width:70%" type="text" placeholder="Cantidad Nueva">
				

			</div>
	</div>
	<div class="modal-footer" style="height: 30px;">
		<button type="submit" class="btn btn-primary">Guardar</button>
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
	</div>
</div>   

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
			<h3 class="profile-title">Gestor Hunters/ Hunter / Detalle Trabajo </h3>
			<legend>
			</legend>								
		</row>
		
		<table id="datatables" class="table">
          <thead>
            <tr>
              <th>Casting</th>
              <th>Asignados</th>
              <th>Revisados</th>
              <th style="width: 30%;">Acci&oacuten</th>
            </tr>
          </thead>
          <tbody>
          	
          	<?php
          	 if(isset($castings))
	          	 foreach ($castings as $casting) {?>
					<tr>
			            <td style="vertical-align:middle;">
			            	<?php echo $casting["casting_name"]?>
			    		</td>
			            <td style="vertical-align:middle;"><?php echo $casting["quantity"]?></td>
		                <td style="vertical-align:middle;"><?php echo $casting["check"] ?></td>
			            <td  style="vertical-align:middle;" class="row center">
				            <div title="Ver Detalle Trabajo Hunter" class="span4">
								<a class="btn" href="<?php echo HOME."/hunter/applicants_list/2/";?>">
									<i class="icon-zoom-in"></i>                                            
								</a>
							</div>
							<div title="Editar Carga" class="span4">
								<button data-toggle="modal"  href="#edit_workload" class="btn" href="">
									<i class="icon-edit"></i>                                            
								</button>
							</div>
							<div title="Liberar Postulantes" class="span4">
								<a class="btn" href="">
									<i class="icon-remove"></i>                                            
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