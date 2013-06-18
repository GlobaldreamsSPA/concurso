<script type="text/javascript">

	$('body').css('overflow', 'hidden');

    var state_des = true;
    $("#des").click(function () {

		$("#des").css("z-index","0");
		$("#pri").css("z-index","-1");
		$("#bas").css("z-index","-1");
		$("#ste").css("z-index","-1");

        if (state_des) {
            $("#des").animate({
                height: 411,
                width: "55%"
            }, 1000);
            $("#des-text").append($("#text-des").html());
        } else {
            $("#des").animate({
                height: 200,
                width: "27%"
            }, 1000, function(){
				$("#pri").css("z-index","0");
				$("#bas").css("z-index","0");
				$("#ste").css("z-index","0");
				}
            );
            $("#des-text").empty();
 

        }
  
		state_des = !state_des;
    });

    var state_pri = true;
    $("#pri").click(function () {

		$("#des").css("z-index","-1");
		$("#pri").css("z-index","0");
		$("#bas").css("z-index","-1");
		$("#ste").css("z-index","-1");

        if (state_pri) {
            $("#pri").animate({
                height: 411,
                width: "55%"
            }, 1000);
            $("#pri-text").append($("#text-pri").html());
        } else {
            $("#pri").animate({
                height: 200,
                width: "27%"
            }, 1000, function(){
				$("#des").css("z-index","0");
				$("#bas").css("z-index","0");
				$("#ste").css("z-index","0");
				}
            );
            $("#pri-text").empty();
              
        }
  
		state_pri = !state_pri;
    });
	
	var state_bas = true;
    $("#bas").click(function () {

		$("#des").css("z-index","-1");
		$("#pri").css("z-index","-1");
		$("#bas").css("z-index","0");
		$("#ste").css("z-index","-1");

        if (state_bas) {
            $("#bas").animate({
                height: 411,
                width: "55%"
            }, 1000);
            $("#bas-text").append($("#text-bas").html());

        } else {
            $("#bas").animate({
                height: 200,
                width: "27%"
            }, 1000, function(){
				$("#des").css("z-index","0");
				$("#pri").css("z-index","0");
				$("#ste").css("z-index","0");
				}
            );
            $("#bas-text").empty();
          
        }
  
		state_bas = !state_bas;
    });

    var state_ste = true;
    $("#ste").click(function () {

		$("#des").css("z-index","-1");
		$("#pri").css("z-index","-1");
		$("#bas").css("z-index","-1");
		$("#ste").css("z-index","0");

        if (state_ste) {
            $("#ste").animate({
                height: 411,
                width: "55%"
            }, 1000);
            $("#ste-text").append($("#text-ste").html());

        } else {
            $("#ste").animate({
                height: 200,
                width: "27%"
            }, 1000, function(){
				$("#des").css("z-index","0");
				$("#pri").css("z-index","0");
				$("#bas").css("z-index","0");
				}
            );
            $("#ste-text").empty();

        }
  
		state_ste = !state_ste;
    });


    var close_elements= ".modal-backdrop, .close";
    var toggle = true;

	if ($("#contest-link").attr("href") == 'video' || $("#contest-link").attr("href") == 'trivia') 
		{
			$('#contest-link').click(function (event)
			{
			    event.preventDefault();
			    if (toggle) {
			    
			    $(".upload-content").css("display","inline");
	            $("#contestmodal").css("overflow","hidden");

	            $("#des").animate({
	                width: "1%"
	            }, 1000);

	            $("#pri").animate({
	                width: "1%",
	            }, 1000);

	            $("#bas").animate({
	                width: "1%",
	            }, 1000);

	            $("#ste").animate({
	                width: "1%",
	            }, 1000, function(){
	            	$(".upload-content").css("z-index","0");
				});
				

		        } else {
		        	$(".upload-content").css("z-index","-1");

		            $("#des").animate({
		                width: "27%"
		            }, 1000);

		            $("#pri").animate({
		                width: "27%",
		            }, 1000);

		            $("#bas").animate({
		                width: "27%",
		            }, 1000);

		            $("#ste").animate({
		                width: "27%",
		            }, 1000, function(){
	            	$(".upload-content").css("display","none");
					});

		           	$("#contestmodal").css("overflow","visible");

		        }

		       	toggle=!toggle;
			});
		}else
		{
			close_elements = close_elements + ", .btn-primary";
		}


	$(close_elements).bind("click", function() {
	    $("#contestmodal").fadeOut(500, function () {
			$(this).remove();
		});
	    $(".modal-backdrop").fadeOut(500, function () {
			$(this).remove();
		});

		$('body').css('overflow', 'visible');

	});



</script>



<div style="margin-left:10px;" class="row">
	<div class="span11">
	<h2 class="modal-title" style="text-align: center; position:relative; z-index: -1;" id="profile">	<?php echo $title; ?> </h2>
	</div>
	<div class="span1">
		<h2><a class="close" data-dismiss="modal"><span class="fui-cross"></span></a> </h2>
	</div>
</div>
<div style="margin-left:10px; margin-top:2%; margin-bottom:2%; height: 90%;" class="row">
	<div class="span5" style="padding-right: 2%;">
		<img src='<?php echo $full_image; ?>'/>
		<div style="margin-top: 5%; margin-bottom: 5%;">
			<?php 
				echo "<a href='".HOME."/home?search_terms=&category=".$category_id."&prize=' target='_blank' class='btn btn-inverse tag'>".$category."</a>";
				
				foreach ($prizes as $id => $prize ) 
					if($prize!="")
					{
						echo "<a href='".HOME."/home?search_terms=&category=&prize=".$id."' target='_blank' class='btn btn-inverse tag'>".$prize."</a>";
					}
			?>
		</div>
		<div style="text-align: center;">
			<span class="fui-time"></span>
			<?php
				echo $days." d&iacute;as para concursar"; 			
			?>
		</div>

		<!-- Codigo para mostrar el publicador del concurso, ver despues-->
		
		<?php /*
		<div class="span8">
			<div class="span6">
				<img style="max-width:50px;"src='<?php echo $logo; ?>'/>
			</div>
			<div class="span6">
				<?php echo $entity; ?>
			</div>
		</div>
		*/ ?>


	</div>
	<div class="span7" id="info-contest" style="height:420px;">
		<div id="des">
			<h3 style="text-align: center; margin-top:80px; color:#ffffff;">
				Descripci&oacute;n
			</h3>
			<div id="des-text" style="color:#ffffff; padding:5%; font-size:15px;">
			</div>
		</div>
		<div id="pri">
			<h3 style="text-align: center; margin-top:80px; color:#ffffff;">
				Premios
			</h3>
			<div id="pri-text" style="color:#ffffff; padding:5%; font-size:15px;">
			</div>
		</div>
		<div id="bas">
			<h3 style="text-align: center; margin-top:80px; color:#ffffff;">
				¿Puedo Concursar?
			</h3>
			<div id="bas-text" style="color:#ffffff; padding:5%; font-size:15px;">
			</div>
		</div>
		<div id="ste">
			<h3 style="text-align: center; margin-top:80px; color:#ffffff;">
				¿Como Concursar?
			</h3>
			<div id="ste-text" style="color:#ffffff; padding:5%; font-size:15px;">
			</div>
		</div>
		
		<?php
			if(strcmp($apply_url, "video") == 0) 
			{
		?>
			<div class="upload-content" style="display:none; z-index: -1; margin-left: 1.5%; margin-right: 3%; position:absolute;">
				<ul class="nav nav-tabs">
				  <li class="active"><a href="#enlazar" data-toggle="tab">Desde Youtube</a></li>
				  <li><a href="#pc" data-toggle="tab">Desde tu PC</a></li>
				</ul>
				<div class="tab-content">
				  <div class="tab-pane active" id="enlazar">
				  	<form id="video_upload_form" action="<?php echo HOME.'/user/'?>" method="post">
				  		<div style="padding:2%;"class="row">
					  		<div class="span12">
								<input name="url_ytb" style="width:96%" type="text" placeholder="Dirección - URL video" value="" required="required">											
								<div class="space1"></div>
								<div style="margin-top: 1%; font-size: 95%;"class="justify">
										Debes pegar la dirección URL de tu video. La que se aprecia en la barra del navegador	Ej:   
										<ul>
											<li>http://www.youtube.com/watch?v=LautYzjYv3A</li>
											<li>http://youtu.be/LautYzjYv3A</li>
										</ul>
								</div>
								<button type="submit" class="btn btn-primary">Subir</button>
		
							</div>
				  		</div>
				  	</form>
				  </div>
					<div class="tab-pane" id="pc">
						<form id="video_upload_form" action="<?php echo HOME.'/subevideo/subir_video'?>" method="post">
							<div style="padding:2%;"class="row">
								<div class="span12">
								<input type="file" class="file" name="userfile" size="20" required="required"/><br />	
								<div class="space1"></div>
								<div style="margin-top: 2%; font-size: 95%;" >
									Para utilizar este medio de subida de videos, tienes que tener en cuenta:
									<ul style="margin-top:1px;">
									<li>El tamaño máximo de los videos debe ser de 20 mb.</li>
									<li>Si no sabes como disminuir el tamaño de tu video, ingresa a <a href="http://video.online-convert.com/es/convertir-a-flv" target="_blank">este link</a>.</li>
									<li>Se paciente al momento de subir tu video, el formulario se redirigirá automáticamente.</li>
									<ul>
								</div>
								<button type="submit" class="btn btn-primary">Subir</button>
							</div>
						</form>
					</div>
				</div>
				<div class="justify" style="-webkit-box-shadow: 3px 3px 2px rgba(50, 50, 50, 0.43); -moz-box-shadow:    3px 3px 2px rgba(50, 50, 50, 0.43); box-shadow:         3px 3px 2px rgba(50, 50, 50, 0.43);background-color:#e5e5e5; padding:1%; font-size:82%;">*Si tienes una cuenta de gmail te recomendamos intentar subir tu video utilizando Youtube, para luego enlazarlo (pestaña "desde youtube"), desde el siguiente enlace: <a href="http://www.youtube.com/upload" target="_blank">Youtube Upload</a>. Si tienes algún problema, <a href="mailto:contacto@viddon.com">Cont&aacutectanos</a>.</div>
			</div>
		<?php
			}
			if(strcmp($apply_url, "trivia") == 0)
			{
		?>
			<div class="upload-content" style="display:none; z-index: -1; margin-left: 1.5%; margin-right: 3%; position:absolute;">
				<?php
					if($custom_options != FALSE)
					{
						for($i=0; $i < count($custom_options); $i++) {
							echo "<div style='padding-left:3%'class='row'";
							if(strcmp($custom_options[$i]['type'], 'text') == 0)
							{
								//Pregunta va h5 y texto es textarea
								echo "<h5>".$custom_options[$i]['text']."</h5>";
								echo "<br>";
								echo "<textarea name='custom_text_answer_".$custom_options[$i]['id']."'style='resize: none; width: 97%; margin-top: 15px;' placeholder='La respuesta del postulante iría acá'></textarea>";
							}
							if(strcmp($custom_options[$i]['type'], 'select') == 0)
							{
								//Pregunta va h5 y se crea un select con varios options
								echo "<h5>".$custom_options[$i]['text']."</h5>";
								echo "<br>"; 
								echo "<br>";

								echo "<select name='custom_select_answer_".$custom_options[$i]['id']."'>";
								foreach ($custom_options[$i]['options'] as $option)
								{
									echo "<option value='".$option['id']."'>".$option['option']."</option>";
								}
								echo "</select>";
							}
							if(strcmp($custom_options[$i]['type'], 'multiselect') == 0)
							{
								//Pregunta va h5 y se crea un select chozen
								echo "<h5>".$custom_options[$i]['text']."</h5>";
								echo "<br>";
								echo "<br>";

								$options =  array();
								foreach ($custom_options[$i]['options'] as $option)
								{
									$options[$option['id']] = $option['option'];
								}

								echo form_multiselect("custom_multiselect_answer_".$custom_options[$i]['id']."[]", $options ,NULL,"class='chzn-select chosen_filter' style='width:300px;' data-placeholder='Selecciona tus respuestas..'");
							}
							echo "</div>";
						}
					}
				?>
			</div>
		<?php		
			}
		?>
	</div>
</div>
<div style="margin-right:2%;" class="row">
	<a id="contest-link" class="btn btn-primary pull-right" target="_blank" href="<?php echo $apply_url; ?>">CONCURSAR</a>
</div>

<div id="text-des" style="display:none;">
	<?php echo $description; ?>
</div>

<div id="text-pri" style="display:none;">
	<?php echo $prizes_description; ?>
</div>

<div id="text-bas" style="display:none;">
	<?php echo $bases; ?>
</div>

<div id="text-ste" style="display:none;">
	<?php echo $steps; ?>
</div>