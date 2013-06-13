<!-- CARGO EL MODAL-->
	<script type="text/javascript">

		function show_trivia_options()
		{
			tag = $("#type_contest option:selected").text();

			if(tag != "Trivia")
			{
				$("#trivia").css("display", "none");
			}
			else
			{
				$("#trivia").css("display", "");
			}

			if(tag != "Compartir")
			{
				$(".sharer_questions").css("display", "none");
			}
			else
			{
				$(".sharer_questions").css("display", "");
			}

		}

		function get_index_value()
		{
			var select = document.getElementById('modal-body').getElementsByTagName('select')[0];
			var index = select.selectedIndex;
			var option = select.getElementsByTagName('option')[index];
			var value = option.getAttribute('value');
			return value;
		}

		function clean_modal_body_form()
		{
			load_form('select');
			title_text = document.getElementById('added_question').value = "";
			document.getElementById('modal-body').getElementsByTagName('select')[0].selectedIndex = 2;
		}

		function load_form(value)
		{
			if(typeof value == 'undefined')
			{
				value = get_index_value();
			}

			modal_body = document.getElementById('modal-body');
			modal_body.removeChild(modal_body.getElementsByTagName('div')[0]);

			var element = document.createElement('div');
			var div = document.getElementById('modal-body').appendChild(element);

			if(value == 'text')
			{
				atribute = ['style', 'cols', 'rows', 'placeholder','disabled'];
				value = ['resize: none; width: 97%; margin-top: 15px;', '50', '3','La respuesta del postulante iría acá','disabled'];

				var textarea = document.createElement('textarea');

				for(var i=0; i < atribute.length; i++)
				{
					textarea.setAttribute(atribute[i], value[i]);
				}
				div.appendChild(textarea);
			}

			if(value == 'select' || value == 'multiselect')
			{
				var h4 = document.createElement('h4');
				h4.innerHTML = 'Ingresar alternativas';

				if(value == 'select')
				{
					var input_sel = document.createElement('input');
					input_sel.setAttribute('type', 'radio');
					input_sel.setAttribute('style', 'position: relative; top: -06px;');
				}

				if(value == 'multiselect')
				{
					var input_sel = document.createElement('input');
					input_sel.setAttribute('type', 'checkbox');
					input_sel.setAttribute('style', 'position: relative; top: -06px;');
				}

				var input_text = document.createElement('input');
				input_text.setAttribute('type', 'text');
				input_text.setAttribute('onkeypress', "change_event(event)");
				input_text.setAttribute('onkeydown', "change_event(event)");
				input_text.setAttribute('style', "margin-bottom: 10px; margin-left: 4px;");
				input_text.setAttribute('class', 'added_option');

				var anchor = document.createElement('a');
				anchor.setAttribute('onclick', 'add_question(this)');
				anchor.setAttribute('style', 'margin-left: 4px; position: relative; top: -4px; cursor: pointer;');
				anchor.innerHTML = "Agregar otro campo";
				div.appendChild(h4);
				div.appendChild(input_sel);
				div.appendChild(input_text);
				div.appendChild(anchor);
			}
		}

		function add_question(anchor)
		{
			value = get_index_value();

			if(value == 'select')
			{
				var input_sel = document.createElement('input');
				input_sel.setAttribute('type', 'radio');
				input_sel.setAttribute('style', 'position: relative; top: -06px;');
			}
			
			if(value == 'multiselect')
			{
				var input_sel = document.createElement('input');
				input_sel.setAttribute('type', 'checkbox');
				input_sel.setAttribute('style', 'position: relative; top: -06px;');
			}

			var input_text = document.createElement('input');
			input_text.setAttribute('type', 'text');
			input_text.setAttribute('style', 'margin-left: 4px; margin-bottom: 10px;');
			input_text.setAttribute('onkeypress', 'change_event(event)');
			input_text.setAttribute('onkeydown', 'change_event(event)');
			input_text.setAttribute('class', 'added_option');

			anchor.parentElement.appendChild(document.createElement('br'));
			anchor.parentElement.appendChild(input_sel);
			anchor.parentElement.appendChild(input_text);
			anchor.parentElement.appendChild(anchor);
		}

		function change_event(event)
		{
			console.log(event);
			//Capturar el evento al presionar tab o keydown
			if((event.charCode == 0 && event.keyCode == 9) || (navigator.userAgent.indexOf('Chrome') != -1 && event.charCode == 0 && event.keyCode == 40))
			{
				if(event.keyCode == 9)
				{
					var offset = 2;
				}
				else if(event.keyCode == 40 && navigator.userAgent.indexOf('Chrome') != -1)
				{
					var offset = 1;
				}

				add_question(body_elem.getElementsByTagName('a')[0]);
				body_elem = document.getElementById('modal-body');
				
				input_elements = body_elem.getElementsByTagName('input');
				input_elements[input_elements.length - offset].focus();
			}
		}

		function save_options()
		{
			value = get_index_value();

			title_text = document.getElementById('added_question').value;

			if(value != "text")
			{
				var options = document.getElementById('modal-body').getElementsByClassName('added_option');
				var string_options = options.item(0).value.trim() + "@#";

				for(var i=1; i< options.length; i++)
				{
					if(options.item(i).value.trim() != '')
						string_options = string_options.concat(options.item(i).value.trim()+ "@#");
				}
				 
				if(string_options.substring(0,2) == "@#")
				{
					string_options = string_options.substring(2, string_options.length-2);
				}
				else
				{
					string_options = string_options.substring(0, string_options.length-2);
				}

				addQuestionData(value, title_text, string_options);
			}
			else
			{
				addQuestionData(value, title_text, '');
			}

			//Limpiar formulario
			clean_modal_body_form();
		}

		jQuery(".modal-backdrop, #add_question .close, #add_question .btn").live("click", function() {
	        clean_modal_body_form();
			});

	</script>
    <div id="add_question" class="modal hide fade" style="width: 430px !important;" tabindex="-1" role="dialog" aria-labelledby="AgregaVideo" aria-hidden="true">
      <form class="form-horizontal">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Agregar Pregunta</h3>
        </div>
        <div class="modal-body" id="modal-body">
		        <select id="modal-body-select" onchange="load_form()">
					<option value="text">Pregunta de Texto</option>
					<option value="multiselect">Pregunta de selección múltiple</option>
					<option value="select" selected="selected">Pregunta de selección puntual</option>
				</select>
			<h4>Ingresar pregunta</h4>
			<input type="text" placeholder='Ingresar pregunta acá' id="added_question" style="width: 97%;"/>
			<div>
				<h4>Ingresar alternativas</h4>
				<input type="radio" style="position: relative; top: -06px;"/>
				<input type="text" class="added_option" style="margin-bottom: 10px;" onkeydown="change_event(event)" onkeypress="change_event(event)"/>
				<a onclick="add_question(this);" style="margin-left: 5px; position: relative; top: -4px; cursor: pointer;">Agregar otro campo</a>
            </div>
        </div>
        <div class="modal-footer" style="height: 30px;">
          <a class="btn btn-primary" data-dismiss="modal" onclick="save_options(this)">Guardar</a>
          <button class="btn" data-dismiss="modal" aria-hidden="true" onclick="clean_modal_body_form()">Cerrar</button>
        </div>
      </form>
    </div>      <!-- MODAL-->

<div class="row-fluid">		
	<div class="span3 user-profile-left">
		<img class='user_image' src="<?php echo HOME."/img/logo_hunter/".$user_data['logo'] ?>"/>
		<div class="space4"></div>
		
		<div class="span9 offset1">
			<ul class="nav nav-pills nav-stacked orange">
			  <li><a href="<?php echo HOME."/hunter";?>"> <i class="icon-user"></i> Perfil</a> </li>
			  <li><a href="<?php echo HOME."/hunter/edit/";?>"> <i class="icon-pencil"></i> Editar Datos</a></li>
			  <li class="active"><a> <i class="icon-edit"></i> Nuevo Concurso</a></li>
			  <li><a  href="<?php echo HOME."/hunter/casting_list";?>"> <i class="icon-list"></i> Mis Concursos</a></li>
			  <li><a href="<?php echo HOME."/hunter/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
			</ul>
		</div>
	</div>
	
	<div class="span8 offset1 user-profile-right">
			
		<div class="space1"></div>
		<div class="space1"></div>
		<?php echo form_open_multipart('hunter/publish', array('class' => 'form-horizontal')); ?>
			<legend><h1> Publicar un nuevo Concurso </h1></legend>
			<div style="margin-left:15px;">
				
				<h5>Tipo de Concurso</h5>
				<select id="type_contest" class="span5" name="category" onchange="show_trivia_options()">
					<?php
						foreach($categories as $cat)
						{
							echo "<option value='".$cat."'>".$cat."</option>";
						}
					?>
				</select>

				<h5>Fecha de inicio</h5>
				<input type="text" style="width: 30%;" id="dp1" name="start-date">
				<h5>Fecha de t&eacutermino</h5>
				<input type="text" style="width: 30%;" id="dp2" name="end-date">

				<h5>T&iacutetulo</h5>
				<input type="text" name="title" style="width: 40%;" placeholder="Ingrese el t&iacute;tulo del Concurso">
				<?php echo form_error('title'); ?>


				<h5>Meta Postulantes</h5>
				<input type="text" name="max_applies" style="width: 40%;" placeholder="Ingresa Cantidad" value="<?php if(isset($update_values)) echo $update_values["max_applies"]; else echo set_value('max_applies');?>">
				<?php echo form_error('max_applies'); ?>
	
				<h5>URL Postulaci&oacute;n</h5>
				<input type="text" name="apply_url" style="width: 40%;" placeholder="Ingresa URL">
						
				<h5>Imagen para mostrar</h5>
				<?php echo form_upload(array('name' => 'logo','class'=> 'file')); ?>
				<?php
					echo form_hidden('image','');
					echo form_error('image');
				?>

				<h5>Premios</h5>
				<?php 
				
				echo form_multiselect('prizes[]', $prizes,NULL,"class='chzn-select chosen_filter' style='width:60%' data-placeholder='Selecciona los premios...'");
				?>
				
				<h5>Descripci&oacuten o llamado a postular</h5>
				<textarea class="span3" name="description"> </textarea>
				<?php echo form_error('description'); ?>

				<h5>Pasos para Postular</h5>
				<textarea class="span3" name="steps"> </textarea>
				<?php echo form_error('steps'); ?>

				<h5>Premios del concurso</h5>
				<textarea class="span3" name="prizes_description"> </textarea>
				<?php echo form_error('prizes_description'); ?>

				<h5>Bases del concurso</h5>
				<textarea class="span3" name="bases"> </textarea>
				<?php echo form_error('bases'); ?>

				<div class="space1"></div>

				<div id="trivia" style="height:250px; overflow-y:scroll; padding: 1%; display: none;">
						<div class="span8">
				    	<legend><h3> Preguntas Personalizadas</h3></legend>

						</div>

						<div style="margin-top:15px;" class="span4">
								<button data-toggle="modal"  href="#add_question" class="btn btn-primary">Agregar Pregunta</button>
						</div>
					<legend></legend>

					
					<!-- SCRIPT PARA GENERAR FILAS EN LA TABLA -->
					<script>
						<!-- @param type Tipo de pregunta @param value Los valores de las posibles respuesta, en caso de ser de seleccion -->
						function addQuestionData(type, title, value)
						{	
							//obtener el numero de la pregunta previa
							var separador1 = '|$';
							var separador2 = '|*'; 
							var question_number = document.getElementsByClassName('pregunta').length; //numero de ultima pregunta ingresada
							var hidden_data = "<input type='hidden' value='type|$"+type+"|*title|$"+title+"|*valores|$"+value+"' class='pregunta' name='question_"+question_number+"' />";
							$('#tablapreguntas').find('tbody:last').append(hidden_data);

							var reguleque = new RegExp('@#','g');
							
							value = value.replace(reguleque,',');
							$('#tablapreguntas').find('tbody:last').append("<tr><td>"+type+"</td><td>"+title+"</td><td>"+value+"</td></tr>");
							
						}
					</script>
					<!-- enlaces creadores/llamadores de la funcion -->
					
					<!-- LA TABLA DE PREGUNTAS -->
					<table class="table table-bordered table-condenced table-hover" id="tablapreguntas" name="latabla">
			          <thead> 
			            <tr>
			              <th>Tipo</th>
			              <th>Titulo</th>
			              <th>Alternativas/Pregunta</th>
			            </tr>
			          </thead>
			          <tbody>   
			          </tbody>
			        </table>
			        <div class="space2">
			        </div>
		    	</div>

		    	<div class="sharer_questions" style="display:none;">

			    	<legend><h3> Campos del link para compartir</h3></legend>

			    	<h5>Descripci&oacuten</h5>
					<textarea class="span3" name="share_description"> </textarea>

					<h5>Titulo</h5>
					<input type="text" name="share_title" style="width: 40%;" placeholder="Escribe titulo del link" />
				
					<h5>Imagen del link</h5>
					<?php echo form_upload(array('name' => 'share_image','class'=> 'file')); ?>


			    </div>

				<button style="margin-top: 2%;"type="submit" class="btn btn-primary">Publicar Concurso</button>

			</div>
		
		</form>
	</div>			
</div>
<div class="row-fluid">	
	<div class="space4"></div>	
</div>
<script>
	body_elem = document.getElementById('modal-body');
</script>
