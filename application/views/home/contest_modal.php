<script type="text/javascript">

	$('body').css('overflow', 'hidden');

	/* Funcion de la animacion de la informacion del concurso, de modo que al hacer click en
	uno de los bloques se ocultan los otros */
	var contest_information_animation_onmouseleave = function(event)
	{
		if(event.data.state == false)
		{
			$(event.data.target).animate({
	                height: 200,
	                width: "27%"
	            }, 1000, function(){
					$(event.data.div1).css("z-index","0");
					$(event.data.div2).css("z-index","0");
					$(event.data.div3).css("z-index","0");
					}
	            );
	        $(event.data.target_text).empty();
	        event.data.state = !event.data.state;
	    }
	}

	var contest_information_animation = function (event) 
	{
			
		$(event.data.target).css("z-index","0");
		$(event.data.div1).css("z-index","-1");
		$(event.data.div2).css("z-index","-1");
		$(event.data.div3).css("z-index","-1");

        if (event.data.state) {
            $(event.data.target).animate({
                height: 410,
                width: "55%"
            }, 1000);
            $(event.data.target_text).append($(event.data.source_text).html());
        } else {
            $(event.data.target).animate({
                height: 200,
                width: "27%"
            }, 1000, function(){
				$(event.data.div1).css("z-index","0");
				$(event.data.div2).css("z-index","0");
				$(event.data.div3).css("z-index","0");
				}
            );
            $(event.data.target_text).empty();

        }
  		event.data.state = !event.data.state;
    };

    var stade_des = {target: '#des', div1: '#pri', div2: '#bas', div3: '#ste', state: true, target_text: '#des-text', source_text: '#text-des'};
	$("#des").click(stade_des, contest_information_animation);
	$("#des").mouseleave(stade_des, contest_information_animation_onmouseleave);

	var state_pri = {target: '#pri', div1: '#des', div2: '#bas', div3: '#ste', state: true, target_text: '#pri-text', source_text: '#text-pri'};
	$("#pri").click(state_pri, contest_information_animation);
	$("#pri").mouseleave(state_pri, contest_information_animation_onmouseleave);

  	var state_bas = {target: '#bas', div1: '#des', div2: '#pri', div3: '#ste', state: true, target_text: '#bas-text', source_text: '#text-bas'};
	$("#bas").click(state_bas, contest_information_animation);
  	$("#bas").mouseleave(state_bas, contest_information_animation_onmouseleave);

  	var state_ste = {target: '#ste', div1: '#des', div2: '#pri', div3: '#bas', state: true, target_text: '#ste-text', source_text: '#text-ste'};
	$("#ste").click(state_ste, contest_information_animation);
	$("#ste").mouseleave(state_ste, contest_information_animation_onmouseleave);

	/* Animacion tipo telon de cine para los concursos de video y trivia*/

    var close_elements= ".modal-backdrop, .close"; /* variable que maneja los elementos que ocacionan que se cierre el modal*/
    var toggle = true;

	if($(".upload-content").length > 0)
	{
		$('#contest-link').click(function (event)
		{
		    event.preventDefault();
		    if (toggle) {
		    
		    $(".upload-content").css("display","inline");
            $("#contestmodal").css("overflow-x","hidden");
            

            var width_boxes = "0.3%";

            $("#des").animate({
                width: width_boxes
            }, 1000);

            $("#pri").animate({
                width: width_boxes,
            }, 1000);

            $("#bas").animate({
                width: width_boxes,
            }, 1000);

            $("#ste").animate({
                width: width_boxes,
            }, 1000, function(){
            	$(".upload-content").css("z-index","0");
            	$('#contest-link').text("VOLVER");
            	$('#contest-link').removeClass('btn-primary');
            	$('#contest-link').addClass('btn-info');
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
	            }, 1000, function()
	            {
	            	$(".upload-content").css("display","none");
	            	$('#contest-link').text("CONCURSAR");
	            	$('#contest-link').removeClass('btn-info');
	            	$('#contest-link').addClass('btn-primary');
				});

	           	$("#contestmodal").css("overflow","visible");
	        }

	       	toggle=!toggle;
		});
	}

	if((($("#contest-link").attr("href") == 'video' || $("#contest-link").attr("href") == 'trivia') && !($(".upload-content").length > 0)) ||  $("#contest-link").attr("href") == 'none')
	{
			

		$('#contest-link').attr('rel','tooltip');
		$('#contest-link').attr('data-original-title','Debes iniciar sesión para participar');
		$('#contest-link').tooltip();

		$('#contest-link').click(function(event){
	         event.preventDefault();
	      });

	}
		
	if(!($("#contest-link").attr("href") == 'video' || $("#contest-link").attr("href") == 'trivia' || $("#contest-link").attr("href") == 'none'))
		close_elements = close_elements + ", .btn-primary";


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
			if(strcmp($apply_url, "video") == 0 && $logged_in) 
			{
		?>
			<div class="upload-content">
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
			elseif(strcmp($apply_url, "trivia") == 0 && $logged_in)
			{
		?>
			<div class="upload-content">
				<?php
					if($custom_options != FALSE)
					{
						echo "<h3 class='demo-panel-title'>Responde las siguientes preguntas</h3>";

						for($i=0; $i < count($custom_options); $i++) 
						{
							echo "<div style='padding-left:3%'class='row'";
							if(strcmp($custom_options[$i]['type'], 'text') == 0)
							{
								//Pregunta va h5 y texto es textarea
								echo "<h5>".$custom_options[$i]['text']."</h5>";
								echo "<textarea name='custom_text_answer_".$custom_options[$i]['id']."'style='resize: none; width: 70%; margin-top: 15px;' placeholder='La respuesta del postulante iría acá'></textarea>";
								echo "<div class='space05'></div>";
							}
							if(strcmp($custom_options[$i]['type'], 'select') == 0)
							{
								//Pregunta va h5 y se crea un select con varios options
								echo "<h5>".$custom_options[$i]['text']."</h5>";
								echo "<div class='space05'></div>";

								echo "<select name='custom_select_answer_".$custom_options[$i]['id']."'>";
								foreach ($custom_options[$i]['options'] as $option)
								{
									echo "<option value='".$option['id']."'>".$option['option']."</option>";
								}
								echo "</select>";
								echo "<div class='space05'></div>";
							}
							if(strcmp($custom_options[$i]['type'], 'multiselect') == 0)
							{
								//Pregunta va h5 y se crea un select chozen
								echo "<h5>".$custom_options[$i]['text']."</h5>";
								echo "<div class='space05'></div>";

								$options =  array();
								foreach ($custom_options[$i]['options'] as $option)
								{
									$options[$option['id']] = $option['option'];
								}

								echo form_multiselect("custom_multiselect_answer_".$custom_options[$i]['id']."[]", $options ,NULL,"class='chzn-select chosen_filter' style='width: 313px;' data-placeholder='Selecciona tus respuestas..'");
								echo "<div class='space1'></div>";
							}
							echo "</div>";
						}
					echo form_submit("", "CONCURSAR", "id='apply-link' class='btn btn-primary pull-left' target='_blank' style='margin-left: 25%'");
					}
				?>
				
				<!-- Este script es para convertir los multiselects en chozen selects -->
				<script type="text/javascript">
					$(".chzn-select").chosen();
				</script>
			</div>
		<?php		
			}
		?>
			
	</div>
</div>
<div style="margin-right:2%;" class="row">
	<a id="contest-link" class="btn btn-primary pull-right" target="_blank" href="<?php echo $apply_url; ?>">CONCURSAR</a>
</div>


<!-- Texto oculto de las descripciones-->
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