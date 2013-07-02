<div class="row">		
	<div class="span3 user-profile-left top-div-left">
		<div class="row top-title-left" >
			<h1>Perfil</h1>
		</div>


		<div class="row">
    		<div style="padding-left: 3%;" class="span10 offset1">
    			<?php 


					if(file_exists(APPPATH.'/../img/gallery/'.$image_profile_name) == TRUE)
						echo "<img class='user_image' src='".HOME.'/img/gallery/'.$image_profile_name."'/>";
					else
						echo "<img class='user_image' src='".HOME."/img/profile/user.jpg'/>";
					
				?>
				<div class="space2"></div>


    			<ul class="nav nav-pills nav-stacked">
					<li><a href="<?php echo HOME.'/user'?>"> <i class="icon-th-large"></i> Postulaciones Activas</a></li>											
					<li><a href="<?php echo HOME.'/user/results_casting'?>"> <i class=" icon-star"></i> Resultados de Concursos</a></li>											
					<li class="active"><a> <i class="icon-edit"></i> Editar Datos</a></li>	
					<li><a href="<?php echo HOME."/user/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
				</ul>
			</div>
		</div>
	</div>

	<?php 
	
	echo form_open_multipart(); ?>

    <div class="span9 user-profile-right top-div-right"> 	
		<div class="row top-title" >
			<h1>Edita tus datos personales</h1>
		</div>

		<div style="margin-left:15px;">
			<div class="row">
				<div class="span6">								
					<h5>Nombres</h5>
					<input type="text" style="width:100%;" placeholder="Escribe tu Nombre Aqui" value="<?php if(isset($update_values)) echo $update_values["name"]; else echo set_value('name');?>" name="name">
				</div>
			</div>
			<div class="row">
			<?php echo form_error('name'); ?>
			</div>
			<div class="row">
				<div class="span6">								
					<h5>Apellidos</h5>
					<input type="text" style="width:100%;" placeholder="Escribe tu Nombre Aqui" value="<?php if(isset($update_values)) echo $update_values["last_name"]; else echo set_value('last_name');?>" name="last_name">
				</div>
			</div>
			<div class="row">
			<?php echo form_error('last_name'); ?>
			</div>
			<div class="row">
				<div class="span6">								
					<h5>Correo</h5>
					<input type="text" style="width:100%;" placeholder="Escribe tu Nombre Aqui" value="<?php if(isset($update_values)) echo $update_values["email"]; else echo set_value('email');?>" name="email">
				</div>
			</div>
			<div class="row">
			<?php echo form_error('email'); ?>
			</div>
			<div class="space2"></div>														
			
			
		</div>
		<legend>Informaci&oacute;n P&uacute;blica</legend>
		
		<div style="margin-left:5px;">
			<h5>Selecciona tus habilidades</h5>
				<?php 
				
				echo form_multiselect('skills[]', $skills, $update_user_skills,"class='chzn-select' style='width:245px' data-placeholder='Selecciona los tags...'");
				?>
			<?php echo form_error('skills'); ?>

			<h5>Campo Con&oacute;ceme</h5>
				<textarea class="rich_textarea" name="bio"><?php if(isset($update_values)) echo $update_values["bio"]; else echo set_value('bio');?></textarea>
				<?php echo form_error('bio'); ?>
			<div class="space2"></div>
				<button class="btn btn-primary" type="submit"> Guardar Datos </button>
			</form>
			<div class="space4"></div>
		</div>
	</div>

</div>