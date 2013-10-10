<script type="text/javascript">
	$(function() {
		$( ".accordion" ).accordion({active: false});
	});
</script>

<?php 
	if(isset($update_contact_data))
	{
?>
		<script type="text/javascript">
			$(function() {
				/*Eventos a activar cuando se piden los datos faltantes*/
				$('#user-modal').modal({
				  backdrop: 'static',
				  keyboard: false
				});
				$('body').css('overflow', 'hidden');

				$("#user-modal-form").submit(function(){

					var submit = true;

					$('.input-group').each(function() {
						var flag = false;
						var label = $(this).children(".input-error-label");
						var Regex = "";

						if($(this).children(".user-modal-input").attr('id') == "cell_phone")
						{
							if($(this).children(".user-modal-input").val() != "")
							{
								Regex = /^\d{8}$/;
								if(!(Regex.test($(this).children(".user-modal-input").val())))
									flag = true; 
							}
						}
						else
						{
							if($(this).children(".user-modal-input").val() == "")
								flag = true;

							if($(this).children(".user-modal-input").attr('id') == "name" || $(this).children(".user-modal-input").attr('id') == "last_name")
								Regex = /^[A-Za-z ]+$/; 
							else if($(this).children(".user-modal-input").attr('id') == "email")
								Regex = /\S+@\S+\.\S+/;
							else if($(this).children(".user-modal-input").attr('id') == "rut")
								Regex = /^\d{7,8}-[0-9kK]$/; 
						
							if(!(Regex.test($(this).children(".user-modal-input").val())))
								flag = true; 
						}

						
						if(flag)
						{
							label.css("display","block");
							submit = false
						}
						else
							label.css("display","none");
					});

					return submit;

				});
			});
		</script>

		<style type="text/css">
			#user-modal{
			  position: fixed;
			  top: 25%;
			  left: 40%;
			  margin: 0 0 0 -25%;
			  width: 70% !important;
			  border-radius: 0;

			}
			#user-modal .modal-body
			{
				max-height: 100% !important;
			}

			#user-modal .modal-header
			{
				padding: 0;
				background-color: #f5f5f5;

			}
			.modal-backdrop.fade.in{
				opacity: 0.5 !important;
			}
			.user-modal-label
			{
				font-weight: bold;
				width: 33%; 
				display: inline-block;
			}

			#user-modal-title
			{
				background-color: #E67E22 !important;
				margin: 0;
				padding: 10px;
				color: white;				
			}

			#user-modal-subtitle
			{
				padding-top: 5px;
				color: #34495e;
				font-weight: bold;
			}
			.user-modal-input
			{
				width: 60%;
			}
			#user-modal-form
			{
				margin: 0;
			}
			#user-modal-note
			{
				color: #34495e;
				font-size: 14px;
				font-weight: bold;
			}

			.input-error-label {
				display: none;
				font-size: 12px;
				margin-left: 35%;
				margin-top: 0;
				color: #E74C3C;
			}
			.form-error-label {
				font-size: 12px;
				margin-left: 35%;
				margin-top: 0;
				color: #E74C3C;
			}
			.unique-asterisk
			{
				color: #E74C3C;
			}		
		</style>
		<div id="user-modal" class="modal hide fade">
			<div class="modal-header align-center">
				<h1 id="user-modal-title">Datos de Contacto </h1>
				<label id="user-modal-subtitle"> Estos datos son de suma importancia, para contactarte en caso de GANAR</label>
				<label id="user-modal-note" class="align-center">(<span class="unique-asterisk">*</span>Son los campos obligatorios)</label>
			</div>
			<form id="user-modal-form"  method="post" class="form-horizontal">
				<div class="modal-body" >
					<div class="space1"></div>
					<div class="control-group align-center">
						<div class="input-group span6">
							<label class="user-modal-label"><span class="unique-asterisk">*</span>Nombres</label>
							<input class="user-modal-input" type="text" id="name" name="name" value="<?php echo $name; ?>" placeholder="Nombre">
							<label class="input-error-label">Debes ingresar un nombre valido</label>
							<?php echo form_error('name', '<label class="form-error-label">', '</label>'); ?>
						</div>
						<div class="input-group span6">
							<label class="user-modal-label"><span class="unique-asterisk">*</span>Apellidos</label>
							<input class="user-modal-input" type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" placeholder="Apellido">
							<label class="input-error-label">Debes ingresar un apellido valido</label>
							<?php echo form_error('last_name', '<label class="form-error-label">', '</label>'); ?>
						</div>
					</div>
					<div class="control-group align-center">
						<div class="input-group span6">
							<label class="user-modal-label"><span class="unique-asterisk">*</span>Correo</label>
							<input class="user-modal-input" type="text" id="email" name="email" placeholder="El que más utilices" value="<?php echo set_value("email");?>">
							<label class="input-error-label">Debes incluir un correo valido</label>
							<?php echo form_error('email', '<label class="form-error-label">', '</label>'); ?>
						</div>
						<div class="input-group span6">
							<label class="user-modal-label"><span class="unique-asterisk">*</span>RUT</label>
							<input class="user-modal-input" type="text" id="rut" name="rut" placeholder="Ej: 12345678-9" value="<?php echo set_value("rut");?>">
							<label class="input-error-label">Debes ingresar un RUT valido, con guión</label>
							<?php echo form_error('rut', '<label class="form-error-label">', '</label>'); ?>
						</div>
					</div>
					<div class="control-group align-center">
						<div class="input-group span6 offset3">
							<label class="user-modal-label">Celular</label>
							<input class="user-modal-input" type="text" id="cell_phone" name="cell_phone" placeholder="Ej: 81234567" value="<?php echo set_value("cell_phone");?>">
							<label class="input-error-label">Debes ingresar un numero valido</label>
							<?php echo form_error('cell_phone', '<label class="form-error-label">', '</label>'); ?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-primary" value="GUARDAR">
				</div>
			</form>
		</div>
<?php 
	}
?>
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
					<li><a href="<?php echo HOME."/user/edit/";?>"> <i class="icon-edit"></i> Editar Datos</a></li>	
					<li><a href="<?php echo HOME."/user/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
				</ul>
			</div>
		</div>
	</div>
	
    <div class="span9 user-profile-right top-div-right">
    	<div class="row top-title" >
			<h1>Postulaciones Activas a Concursos</h1>
		</div>
		<div class="space2">
		</div>
		<?php 							
			if(isset($castings))
				foreach($castings as $casting)
				{ 
		?>
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
							<form action="<?php echo site_url("casting/delete"); ?>" method="POST">
								<button style="color:white; background: #e67e22;" class="btn" type="submit">
									<span class="fui-cross"></span>
								</button>
								<input type="hidden" name="apply_id" value="<?php echo $casting["apply_id"] ?>"/>
							</form>
						</div>
					</div>
					<div class="row">
						<div style="margin-left:3%;" class="span6">
							<div class="space05"></div>
							<img style='height:100%; width: 100%;' src="<?php echo $casting['full_image'] ?>"/>
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
		<?php 
				}
			else
			{			
		?>
				<div style="margin-left: -4.2%;">
					<div class="space4"></div>
					<div style="text-align:center; font-size: 20px;">
						No has concursado aún, vuelve a la página principal para <a href="<?php echo HOME."/" ?>">concursar</a>
					</div>
					<div class="space4"></div>
				</div>
		<?php
			}
		?>
	</div>					
</div>