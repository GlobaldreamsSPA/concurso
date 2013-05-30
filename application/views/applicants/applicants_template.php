<div id="error" class="modal hide fade in">
<div class="modal-header">
<a class="close" data-dismiss="modal"><i class="icon-remove"></i></a>  
</div>
<div class="modal-body">
<h4>Aviso</h4>
<p><?php if(isset($postulation_message)) echo $postulation_message; ?></p>              
</div>
<div class="modal-footer">
<?php echo anchor(HOME,'Volver al Home',"class='btn btn-green'"); ?>
<a href="#" class="btn" data-dismiss="modal">Volver al Perfil</a>
</div>
</div>

<div id="del-video" class="modal hide fade in" >
<div class="modal-header">  
<a class="close" data-dismiss="modal"><i class="icon-remove"></i></a> 
</div>
<div class="modal-body">
<h4>Aviso</h4>
<p><?php if(isset($delete_video_message)) echo $delete_video_message; ?></p>      
</div>
<div class="modal-footer">
<?php echo anchor('user', 'Volver al Perfil',"class='btn'") ?>
</div>
</div>

<?php if(isset($delete_video_message)){ ?>
<script type="text/javascript">

  $('#del-video').modal({
    show: true
  });
</script>
<?php } ?>

<div class="content" id="content">
	<div class="space4"></div>
	<div class="space4"></div>
	<div class="container-fluid">
	  	<div class="row">
	  		<div class="span9">
	  			<div  style="border-radius: 5px; margin-left:3%;" id="variable" class="row-fluid">
		  			<div style="padding: 2%;">
		  				<?php $this->load->view($applicant_content);  ?>
		  			</div>
		  		</div>
			</div>	
		
			<div class="span3">
				<?php //Si está en su perfil, muestra enlace a la galeria de fotos
				if(!$public)
				{ 
				?>
				<div  style="border-radius: 5px; margin-left:8%; padding-left: 10px; padding-right: 10px; text-align:center;" id="grow" class="row-fluid">
					<div class="space1"></div>
					<h3 id="profile" >Galeria Videos</h3>
					
					<a href="<?php echo HOME.'/user/video_gallery/';?>">
						<img style="margin-top: 16px;" src="<?php echo HOME.'/img/dummy_galeria_videos.png';?>">
					</a>

		  			<a class="MBT-readmore" href="<?php echo HOME.'/user/video_gallery/';?>">Ver m&aacute;s >></a>
		  			
		  			<div class="space4"></div>						
					<h3 id="profile" >Galeria Fotos</h3>

		  			<a href="<?php echo HOME.'/user/photo_gallery/';?>">
					
						<img style="margin-top: 16px;"  src="<?php echo HOME.'/img/dummy_galeria_fotos.png';?>">
					
					</a>				
				
		  			<a class="MBT-readmore" style="float: right;" href="<?php echo HOME.'/user/photo_gallery/';?>">Ver m&aacute;s >></a>
		  			
					<div class="space4"></div>
				</div>
				<?php
				} 
		  		else
		  		{
		  		?>
				<div style="border-radius: 5px; margin-left:8%; text-align:center;" id="grow" class="row-fluid">
			  		<div class="space1"></div>
			  		<h2 id="profile"  style="font-weight:bold;">Casting Viddon</h3>
			  		<?php foreach($castings as $casting){ ?>
			  			<a href="<?php echo site_url("home/casting_detail/".$casting['id']); ?>">
		  					<img style="margin-top: 44px; width: 84%; " src="<?php echo $casting['image']; ?>">
		  				</a>
		  			<?php } ?>
					<div class= "space2"></div>
					
					<div class="social_container">
						<div class="space05"></div>
						<h4 id="profile"> Buscanos en Redes Sociales</h4>
					
						<div class="row">
							<div class="span3">
								<a href="https://twitter.com/ViddonCom" target=”_blank”>
			  						<img style="margin-top: 7%; width: 74%; " src="<?php echo HOME."/img/social_container_t.png"; ?>">
			  					</a>
			  				</div>
			  				<div class="span3">	
			  					<a  href="http://www.facebook.com/pages/Viddoncom/499177723428347?ref=hl" target=”_blank”>
			  						<img style="margin-top: 7%; width: 74%; " src="<?php echo HOME."/img/social_container_f.png"; ?>">
			  					</a>
			  				</div>
			  				<div class="span3">	
			  					<img style="margin-top: 7%; width: 74%; " src="<?php echo HOME."/img/social_container_y.png"; ?>">
			  				</div>
			  				<div class="span3">	
			  					<a  href="http://www.viddon.com/blog" target=”_blank”>
			  						<img style="margin-top: 7%; width: 74%; " src="<?php echo HOME."/img/social_container_w.png"; ?>">
			  					</a>
			  				</div>
		  				</div>
					</div>

					<div class="space1"></div>


					<div style="margin-left: 5%; margin-right: 5%;">
						<a class="twitter-timeline" href="https://twitter.com/ViddonCom" data-widget-id="316343995661959169">Tweets por @ViddonCom</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</div>

					<div class= "space2"></div>

				</div>
				<?php }?>
			</div>
			
		</div>
		
		</div>
		<div class="space4"></div> 	
</div>