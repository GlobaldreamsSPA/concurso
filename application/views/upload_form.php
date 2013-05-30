<?php echo form_open_multipart('subevideo/subir_video');?>
	<div style="padding:2%;"class="row">
		<div class="span6">	
			<input type="file" class="file" name="userfile" size="20" required="required"/><br />
			<input name='uploaded_title' style="margin-top:2%; width:96%" type="text" required="required" placeholder="Titulo del video" /><br />
			<?php echo form_multiselect('video_categories[]', $video_categories_list, null,"class='chzn-select' style='width:245px' data-placeholder='Selecciona las categorias...'"); ?>
			<?php
				if(isset($error))
				{
					//registro el error
					echo($error);
				} 
			
			?><!-- Si ocurrió un error, lo muestra -->

			<div style="margin-top: 2%; font-size: 95%;" >
				Para utilizar este medio de subida de videos, tienes que tener en cuenta:
				<ul style="margin-top:1px;">
				<li>El tamaño máximo de los videos debe ser de 20 mb.</li>
				<li>Si no sabes como disminuir el tamaño de tu video, ingresa a <a href="http://video.online-convert.com/es/convertir-a-flv" target="_blank">este link</a>.</li>
				<li>Se paciente al momento de subir tu video, el formulario se redirigirá automáticamente.</li>
				<li>Youtube tarda unos minutos en procesar videos, por lo que no se veran los videos inmediatamente  .</li>
				<ul>
			</div>
		</div>
		<div class="span6">
			<h4 style="line-height: 18px; margin: 0; margin-bottom: 2%;">Descripci&oacute;n</h4>
			<textarea class="rich_textarea_pop_up" name="uploaded_desc" cols="20" rows="5" placeholder="Descripcion">
			</textarea><br>
			<button type="submit" class="btn btn-primary">Subir</button>
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
		</div>
	</div>
</form>
