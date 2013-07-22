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

<script type="text/javascript">

	if($(window).width() < 930){
		
		$(".responsive-top").removeClass('span7');  
		$(".responsive-top").addClass("row");
		$(".responsive-top").css("padding-left","5%");
		$(".responsive-top").css("margin-left","0");

		$(".responsive-bottom").removeClass('span4');  

		$(".bottom-1").addClass('span8'); 
		$(".bottom-1").addClass('offset2'); 
		$(".bottom-1").css("margin-bottom","10%");
		$(".bottom-1").css("margin-top","5%");


		$(".bottom-2").addClass('span8'); 
		$(".bottom-2").addClass('offset2'); 
		$(".bottom-2").css("margin-bottom","5%");

		$(".removable").removeClass("space4");

	   	
	}else if($(window).width() >= 930)
	{

		$(".responsive-top").addClass('span7');  
		$(".responsive-top").removeClass("row");
		$(".responsive-top").css("padding-left","0");
		$(".responsive-top").css("margin-left","7%");

		$(".responsive-bottom").addClass('span4');  
		
		$(".bottom-1").removeClass('span8'); 
		$(".bottom-1").removeClass('offset2'); 
		$(".bottom-1").css("margin-bottom","0");
		$(".bottom-1").css("margin-top","0");

		$(".bottom-2").removeClass('span8'); 
		$(".bottom-2").removeClass('offset2');    
		$(".bottom-2").css("margin-bottom","0");
		$(".removable").addClass("space4");


	}

	$(window).resize(function(){
		if($(this).width() < 930){
			
			$(".responsive-top").removeClass('span7');  
			$(".responsive-top").addClass("row");
			$(".responsive-top").css("padding-left","5%");
			$(".responsive-top").css("margin-left","0");

			$(".responsive-bottom").removeClass('span4');  

			$(".bottom-1").addClass('span8'); 
			$(".bottom-1").addClass('offset2'); 
			$(".bottom-1").css("margin-bottom","10%");
			$(".bottom-1").css("margin-top","5%");


			$(".bottom-2").addClass('span8'); 
			$(".bottom-2").addClass('offset2'); 
			$(".bottom-2").css("margin-bottom","5%");

			$(".removable").removeClass("space4");

		   	
		}else if($(this).width() >= 930)
		{

			$(".responsive-top").addClass('span7');  
			$(".responsive-top").removeClass("row");
			$(".responsive-top").css("padding-left","0");
			$(".responsive-top").css("margin-left","7%");

			$(".responsive-bottom").addClass('span4');  
			
			$(".bottom-1").removeClass('span8'); 
			$(".bottom-1").removeClass('offset2'); 
			$(".bottom-1").css("margin-bottom","0");
			$(".bottom-1").css("margin-top","0");

			$(".bottom-2").removeClass('span8'); 
			$(".bottom-2").removeClass('offset2');    
			$(".bottom-2").css("margin-bottom","0");
			$(".removable").addClass("space4");
	
	
		}
	});

</script>

<div class="content content_lh" id="content">
	<div class="space4"></div>
	<div class="removable space4"></div>
	<div class="container-fluid">
	  	<div class="row">
	  		<div style="margin-left: 7%;" class="responsive-top span7">
	  			<div style="padding-top:6%;">
				    <p style="text-align:center; margin-left:-3%; color: #4da0d8; line-height: 30px; font-family: 'ganandofont'; font-size: 25px;">LLEGA A MUCHOS USUARIOS DISPUESTOS A FOMENTAR TU MARCA</p>		    						   
					<div class="space2"></div>
					<img src="<?php echo HOME."/img/empresa.png";?>">
		    	</div>
	  		</div>
	  		<div class="responsive-bottom span4" id="variable" style="min-height: 0px !important; ">
		  			<div class="bottom-1">
			  			<div class="row-fluid" style="border-radius: 5px; margin-left:8%">	
			  				<div class="space05"></div>
			  				<h3 style="padding-left:5%; background-color: #E67E22; color: #fff; text-align:center;">Ingreso Empresas</h3>
			  				<div class="space05"></div>
					  		<?php echo form_open('hunter/verifylogin', array('class' => 'form-horizontal')); ?>
								<div style="text-align:right;" class="span6">
									<input style="width:86%;" name="email" value="<?php echo set_value('email'); ?>" type="text" id="inputEmail" placeholder="Correo">
									<?php echo form_error('email'); ?>
									<div class="space1"></div>		            
								</div>

								<div style="margin-left:3.5%; text-align:left;" class="span6">   	
									<input style="width:86%;" name="password" value="<?php echo set_value('password'); ?>" type="password" id="inputPassword" placeholder="Contraseña">
									<?php echo form_error('password'); ?>
									<div class="space1"></div>		            
								</div>
			        			<div class="span5" style="text-align:right;">
									<label class="checkbox">
								    	<input type="checkbox"> Recordar mis datos
								    </label>							
								</div>

								<div class="span6 offset1" style="text-align:right; margin-right:5%;">
									<button style="width:80% !important;" type="submit" class="btn btn-primary">INICIAR SESI&Oacute;N</button>
									<div class="space1"></div>
								</div>
							</form>
						</div>
					</div>
					<div class="space1"></div>
					<div class="bottom-2">
						<div class="row-fluid" style="border-radius: 5px; margin-left:8%;">
					  		<?php echo form_open('home/company', array('class' => 'form-horizontal')); ?>
								
								<div class="space05"></div>
				  				<h3 style="padding-left:5%; background-color: #E67E22; color: #fff; text-align:center;">Cont&aacute;ctanos</h3>
				  				<div class="space05"></div>

								<div style="text-align:right;" class="span6">
						            <input style="width:86%;" type="text" name="contact_name" id="input1" placeholder="Nombre" value="<?php echo set_value('contact_name'); ?>">
									<?php echo form_error('contact_name'); ?>
									<div class="space1"></div>		            
						            
						        </div>
						        <div style="margin-left:3.5%; text-align:left;" class="span6">   	
						           	<input style="width:86%;" type="text" name="contact_email" id="input2" placeholder="Correo" value="<?php echo set_value('contact_email'); ?>">
									<?php echo form_error('contact_email'); ?>
						           	<div class="space1"></div>
								</div>
								<div style="text-align:right;" class="span9">
									<textarea style="width: 87% !important;"  name="contact_message" id="input3" rows="2" placeholder="Mensaje de Contacto"><?php echo set_value('contact_message'); ?></textarea>
									<?php echo form_error('contact_message'); ?>
								</div>

								<div class="span3" style="text-align:right;">
									<button style="margin-right:5%; width: 80%; height:60px; font-size:25px;" type="submit" class="btn btn-primary"><span class="fui-mail"></span></button>
				        		</div>
				        		<div class="span12">
									<div class="space1"></div>
				        		</div>
					        </form>
				        </div>
				    </div>	
	  		</div>
		</div>
  	</div>
  	<div class="space2"></div> 	
</div>