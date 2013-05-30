<div id="add_hunter" class="modal hide fade in" style="width: 350px !important;" tabindex="-1" role="dialog" aria-hidden="true">					
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Agregar Hunter</h3>
	</div>
	<?php echo form_open_multipart(HOME."/hunter/create_sub_hunter/");?>
		<div class="modal-body">
				<div style="text-align:center">	
					<input name="hunter_name" style="width:70%" type="text" value="<?php echo set_value('hunter_name'); ?>" placeholder="Nombre">
					<?php echo form_error('hunter_name'); ?>
					<div class="space1"></div>
					<input name="email" style="width:70%" type="text" value="<?php echo set_value('email'); ?>" placeholder="Correo Usuario">
					<?php echo form_error('email'); ?>
					<div class="space1"></div>
					<input name="pass1" style="width:70%" type="password" value="<?php echo set_value('pass1'); ?>" placeholder="Contrase&ntilde;a">
					<?php echo form_error('pass1'); ?>
					<div class="space1"></div>
					<input name="pass2" style="width:70%" type="password" value="<?php echo set_value('pass2'); ?>" placeholder="Repite Contrase&ntilde;a">
					<?php echo form_error('pass2'); ?>
					<div class="space1"></div>
					<?php echo form_upload(array('name' => 'image_sub_hunter','class'=> 'file')); ?>
					<?php echo form_error('image_sub_hunter'); ?>
					<div class="space1"></div>	
				</div>
		</div>
		<div class="modal-footer" style="height: 30px;">
			<button type="submit" class="btn btn-primary">Guardar</button>
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
		</div>
	</form>
</div>   


<?php if(isset($show)){ ?>
<script type="text/javascript">

  $('#add_hunter').modal({
    show: true
  });
</script>
<?php } ?>

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
			<div class="span10"> 
				<h3 class="profile-title">Gestor Hunters </h3>
			</div>
			<div style="margin-top: 15px;" title="Agregar Hunter" class="span2">
				<button data-toggle="modal"  href="#add_hunter" class="btn">
					<i class="icon-plus"></i>                                            
				</button>
			</div>
			<legend>
			</legend>								
		</row>
		
		<table id="datatables" class="table">
          <thead>
            <tr>
              <th>Imagen</th>
              <th>Nombre</th>
              <th>Estado</th>
              <th style="width: 40%;">Acci&oacuten</th>
            </tr>
          </thead>
          <tbody>
          	
          	<?php
          	 if(isset($hunters))
	          	 foreach ($hunters as $hunter) {
	          	 	?>
					<tr>
			            <td style="vertical-align:middle;">
			            	<img style="max-width: 80px; max-height:80px;" src="<?php echo HOME.'/img/logo_hunter/'.$hunter['logo'] ?>"/>
			    		</td>
			            <td style="vertical-align:middle;"><?php echo $hunter["name"]?></td>
		                <td style="vertical-align:middle;"><span class="label label-info"><?php echo "libre"/*$hunter["status"]*/ ?></span></td>
			            <td  style="vertical-align:middle;" class="row center">
				            <div title="Ver Trabajo Hunter" class="span4">
								<a class="btn" href="<?php echo HOME."/hunter/check_workload";?>">
									<i class="icon-zoom-in"></i>                                            
								</a>
							</div>
							<div title="Asignar Trabajo Hunter"class="span4">
								<a class="btn" href="<?php echo HOME."/hunter/assign_workload";?>">
									<i class="icon-plus"></i>                                            
								</a>
							</div>
							<div title="Editar Datos Hunter" class="span4">
								<div id="edit_hunter<?php echo $hunter['id'] ?>" class="modal hide fade in" style="width: 350px !important;" tabindex="-1" role="dialog" aria-hidden="true">					
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h3 id="myModalLabel">Editar Hunter</h3>
									</div>
									<?php echo form_open_multipart(HOME."/hunter/edit_sub_hunter/".$hunter['id']);?>
										<div class="modal-body">
												<div style="text-align:center">	
													<input name="hunter_name<?php echo $hunter['id']?>" style="width:70%" type="text" value="<?php echo set_value('hunter_name'.$hunter['id'],$hunter['name']); ?>" placeholder="Nombre">
													<?php echo form_error('hunter_name'.$hunter['id']); ?>
													<div class="space1"></div>
													<input name="email<?php echo $hunter['id']?>" style="width:70%" type="text" value="<?php echo set_value('email'.$hunter['id'],$hunter['email']); ?>" placeholder="Correo Usuario">
													<?php echo form_error('email'.$hunter['id']); ?>
													<div class="space1"></div>
													<input name="pass1<?php echo $hunter['id']?>" style="width:70%" type="password" value="<?php echo set_value('pass1'.$hunter['id']); ?>" placeholder="Contrase&ntilde;a">
													<?php echo form_error('pass1'.$hunter['id']); ?>
													<div class="space1"></div>
													<input name="pass2<?php echo $hunter['id']?>" style="width:70%" type="password" value="<?php echo set_value('pass2'.$hunter['id']); ?>" placeholder="Repite Contrase&ntilde;a">
													<?php echo form_error('pass2'.$hunter['id']); ?>
													<div class="space1"></div>
													<?php echo form_upload(array('name' => 'image_sub_hunter'.$hunter['id'],'class'=> 'file')); ?>
													<?php echo form_error('image_sub_hunter'.$hunter['id']); ?>
													<div class="space1"></div>	
												</div>
										</div>
										<div class="modal-footer" style="height: 30px;">
											<button type="submit" class="btn btn-primary">Guardar</button>
											<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
										</div>
									</form>
								</div> 

								<?php if(isset($show_edit[$hunter['id']])){ ?>
									<script type="text/javascript">

									  $('#edit_hunter<?php echo $hunter['id'] ?>').modal({
									    show: true
									  });
									</script>
								<?php } ?>  

								<button data-toggle="modal"  href="#edit_hunter<?php echo $hunter['id']?>" class="btn"><i class="icon-edit"></i> </button>
							</div>
							<div title="Eliminar Datos Hunter" class="span4">

								<a class="btn" href="<?php echo HOME.'/hunter/delete_sub_hunter/'.$hunter['id'];?>">
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