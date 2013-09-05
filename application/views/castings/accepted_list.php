<link href="<?php echo base_url()?>style/jquery.dataTables.css" rel="stylesheet">
<script src="<?php echo base_url()?>js/jquery.dataTables.min.js" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function() {
	    $('#tblData').dataTable( {
	    	"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": $("#url").text()
		} );
		$(document).ajaxSuccess(function() {
			$('#tblData tbody td').each(function() {
				var column = $(this).parent().children().index(this);
				if(column == 1)
					$(this).html("<img src='"+$(this).text()+"'/>");
				if(column == 3)
					$(this).html("<a class='btn' href='mailto:"+$(this).text()+"'><i class='icon-envelope icon-white'></i></a>");
				if(column == 4)
					$(this).html("<input id='"+$(this).text()+"' value='"+$(this).text()+"' name='selected[]'' type='checkbox'>");

			});

		});
			
	} );
</script>

<div id="url" style="display: none"><?php echo HOME."/hunter/list_all/".$id_casting; ?></div>

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
				<li><a href="<?php echo HOME."/hunter/edit/";?>"> <i class="icon-pencil"></i> Editar Datos</a></li>
				<li><a href="<?php echo HOME."/hunter/publish";?>"> <i class="icon-edit"></i> Nuevo Concurso</a></li>
				<li class="active"><a> <i class="icon-list"></i> Mis Concursos</a></li>
				<li><a href="<?php echo HOME."/hunter/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
			</ul>
		</div>
	</div>
</div>

<div style="margin-left:6.5%;" class="span9">
	<div style="padding-left:4%; padding-right:6%; border-top-left-radius:10px; border-top-right-radius: 10px;" class="row-fluid">
		<div style="margin-left:-4% !important; margin-right: -6%;" class="row top-title-left" >
			<h1> Selección de Ganador(es)</h1>					
		</div>
		
		<div class="space2"></div>
		
		<div class="row" style="text-align:center; margin-bottom: 10px;">
			<ul class="breadcrumb" style=" background-color: transparent !important;  font-size:21px; ">
				  <li><a href="<?php echo HOME.'/hunter/casting_list' ?>">Concursos</a><span class="divider">/</span></li>
				  <li><a href="<?php echo HOME.'/hunter/casting_detail/'.$id_casting ?>"><?php echo $name_casting; ?></a> <span class="divider">/</span></li>
				  <li class="active">Participantes</li>
			</ul>		
		</div>	

		<form method="post">
			<table id="tblData" class="table">
	          <thead>
	            <tr>
	            	<th>Nº</th>
					<th>Imagen</th>
					<th>Nombre completo</th>
					<th>Correo</th>
					<th>Ganador </th>
				</tr>
	          </thead>
	          <tbody>
					<tr>
						<td colspan="5" class="dataTables_empty">Loading data from server</td>
					</tr>
	          	</tbody>
	        </table>
			<div class="space4"></div>
			<div class="row">
				<button type="submit" class="btn btn-info pull-right"  style="margin-left:10px;" href="#"><i style="margin-top: 3px; margin-right: 3px;" class="icon-off icon-white"></i>Finalizar Concurso</button>
				<a class="btn btn-info pull-right"  style="margin-left:10px;" href="<?php echo HOME.'/hunter/set_postulation_number/'.$id_casting ?>"> Actualizar Numero Sorteo </a>
				<div class="space4"></div>
			</div>
		</form>	
	</div>
</div>