<div style="margin-left: -3%;" class="span3">
	<div style=" padding-right: 10%; padding-left:10%; border-top-left-radius:10px; border-top-right-radius: 10px;" class="row-fluid">
		<div style="margin-left:-10% !important; margin-right: -11%;" class="row top-title-left" >
			<h1>Perfil</h1>
		</div>
		<img class='user_image' src="<?php echo HOME."/img/logo_hunter/".$user_data['logo'] ?>"/>
		<div class="space4"></div>
		
		<div class="span9 offset1">
			<ul class="nav nav-pills nav-stacked orange">
			  	<li><a href="<?php echo HOME."/hunter";?>"> <i class="icon-user"></i> Perfil</a> </li>
			  	<li class="active"><a> <i class="icon-pencil"></i> Editar Datos</a></li>
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
			<h1>Editar mis datos</h1>					
		</div>
		<?php echo form_open_multipart('hunter/edit','style="margin-left: 10%; max-width:80% !important;"'); ?>
			<div class="space1"></div>
			<h5>Nombre Empresa</h5>
			<div class="space05"></div>
			<input type="text" class="span5" name="name" placeholder="Nombre Empresa/Agencia" value="<?php if(isset($update_values)) echo $update_values["name"]; else echo set_value('name');?>">
			<?php echo form_error('name'); ?>
			<h5>Correo de Contacto</h5>
			<div class="space05"></div>
			<input type="text" class="span5" name="email" placeholder="Correo Contacto" value="<?php if(isset($update_values)) echo $update_values["email"]; else echo set_value('email');?>">
			<?php echo form_error('email'); ?>
			<h5>Ubicación</h5>
			<div class="space05"></div>
			<input type="text" class="span5" name="address" placeholder="Dirección de la empresa" value="<?php if(isset($update_values)) echo $update_values["address"]; else echo set_value('address');?>">
			<?php echo form_error('address'); ?>
										
			<h5>Logo Corporativo</h5>
			<div class="space05"></div>
			<?php echo form_upload(array('name' => 'hunter_profile','class'=> 'file')); ?>
			<?php 
				  echo form_hidden('image','');
				  echo form_error('image'); 
			?>
			
			<h5>Nosotros</h5>
			<div class="space05"></div>
			<textarea  name="about_us"><?php if(isset($update_values)) echo $update_values["about_us"]; else echo set_value('about_us');?></textarea>
			<?php echo form_error('about_us'); ?>
			
			<div class="space2"></div>
			<button class="btn btn-primary pull-right" style="margin-right: -5%;" type="submit"> Guardar Datos </button>
		</form>
		<div class="space2"></div>
	</div>
</div>
