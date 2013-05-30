<div id="success" class="modal hide fade in" >
<div class="modal-header">  
<a class="close" data-dismiss="modal"><i class="icon-remove"></i></a> 
</div>
<div class="modal-body">
<h4>Aviso</h4>
<p>Mensaje registrado con &eacute;xito, nos contactaremos a la brevedad contigo.</p>      
</div>
<div class="modal-footer">
<?php echo anchor('home', 'Volver a la p&aacute;gina principal',"class='btn'") ?>
</div>
</div>

<?php if(isset($flag)){ ?>
<script type="text/javascript">

  $('#success').modal({
    show: true
  });
</script>
<?php } ?>


<div class="content content_lh" id="content">
	<div class="space4"></div>
	<div class="space4"></div>
	<div class="container-fluid">
	  	<div class="row">
	  		<div class="span8">
	  			<div class="hunter_msj">
					    <h2 >Bienvenidos Cazatalentos</h2>
					    <h4>Descubre miles de artistas de los cuales encontrarás a la estrella que estás buscando</h4>
			    </div>
	  		</div>
	  		<div class="span3" id="variable" style="min-height: 0px !important; ">
		  			<div class="row-fluid" style="border-radius: 5px; margin-left:8%">	
		  				<h4 style="margin-left:10%;" id="profile">Ingreso Hunter</h4>
				  		<?php echo form_open('hunter/verifylogin', array('class' => 'form-horizontal')); ?>
							<div  style="text-align:center;">
								<input style="width:75%;" name="email" value="<?php echo set_value('email'); ?>" type="text" id="inputEmail" placeholder="Email">
								<?php echo form_error('email'); ?>
								<div class="space05"></div>
								<input style="width:45%;" name="password" value="<?php echo set_value('password'); ?>" type="password" id="inputPassword" placeholder="Password">
								<button style="margin-left: 4%; width:25% !important;" type="submit" class="btn btn-primary">Entrar</button>
							</div>
							<?php echo form_error('password'); ?>
						</form>
					</div>
					<div class="space1"></div>
					<div class="row-fluid" style="border-radius: 5px; margin-left:8%;">
				  		<?php echo form_open('home/login_hunter', array('class' => 'form-horizontal')); ?>
							<h4 style="margin-left:10%;" id="profile">Cont&aacutectanos</h4>
							<div  style="text-align:center;">
					            <input style="width:75%;" type="text" name="contact_name" id="input1" placeholder="Nombre" value="<?php echo set_value('contact_name'); ?>">
								<?php echo form_error('contact_name'); ?>
								<div class="space1"></div>		            
					            <input style="width:75%;" type="text" name="contact_email" id="input2" placeholder="Correo" value="<?php echo set_value('contact_email'); ?>">
								<?php echo form_error('contact_email'); ?>
					           	<div class="space1"></div>
					           	<textarea style="width:79%;" name="contact_message" id="input3" rows="7" class="span5" placeholder="Mensaje de Contacto"><?php echo set_value('contact_message'); ?></textarea>
								<?php echo form_error('contact_message'); ?>
							</div>
							<div class="space1"></div>
							<div style="text-align:right;">
								<button style="margin-right:10%;   width:25% !important;" type="submit" class="btn btn-primary">Enviar</button>
				        	</div>
				        </form>
			        </div>	
	  		</div>
		</div>
  	</div>
  	<div class="space2"></div> 	
</div>