<link href="<?php echo base_url()?>style/jquery.dataTables.css" rel="stylesheet">
<script src="<?php echo base_url()?>js/jquery.dataTables.min.js" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function() {
	    $('#tblData').dataTable();
	} );
</script>

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
			<h1>Lista de Fotos</h1>					
		</div>
		
		<div class="space2"></div>
		
		<div class="row" style="text-align:center; margin-bottom: 10px;">
			<ul class="breadcrumb" style=" background-color: transparent !important;  font-size:21px; ">
				  <li><a href="<?php echo HOME.'/hunter/casting_list' ?>">Concursos</a><span class="divider">/</span></li>
				  <li><a href="<?php echo HOME.'/hunter/casting_detail/'.$id_casting ?>"><?php echo $name_casting; ?></a> <span class="divider">/</span></li>
				  <li class="active">Fotos</li>
			</ul>		
		</div>	

		<div class="row" style="margin-top:15px; left:0 !important;">

			<table id="tblData" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th style="text-align: center;">Foto</th>
						<th style="text-align: center;">Descripción</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						if($photos)
							foreach ($photos as $photo){
						?>
								<tr>
									<td style="text-align: center; vertical-align: middle;"><img src="<?php echo HOME."/img/contest_photo/".$photo["name"] ?>" /></td>
									<td style="text-align: center; vertical-align: middle;"><?php echo $photo["description"] ?></td>
								</tr>
						<?php	
							} 
					?>
				</tbody>
			</table>
		</div>
		<div class="space2"></div>
	</div>
</div>