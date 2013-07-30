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

		<table id="tblData" class="table">
          <thead>
            <tr>
            	<th>Nº</th>
				<th>Imagen</th>
				<th>Nombre completo</th>
			<!--
				<th>Edad</th>
				<th>Sexo</th>
			-->
				<th>Correo</th>
				<th>Ganador </th>
			</tr>
          </thead>
          <tbody>
          	
          	<?php
          	 if(isset($applicants))
          	 {
          	 	$i=1;

	          	foreach ($applicants as $applicant) 
	          	{
	          	?>
					<tr>
						<td style="vertical-align:middle;" class="center"><?php echo $i;?></td>
			            <td style="vertical-align:middle;">
			            	<img style="max-width: 80px; max-height:80px;" src="<?php echo HOME."/img/gallery/".$applicant["image_profile"] ?>"/>
			    		</td>
			            <td style="vertical-align:middle;"><?php echo $applicant["name"]." ".$applicant["last_name"]?></td>
			            
			        <!--
			            <td style="vertical-align:middle; text-align:center;"><?php
						         //explode the date to get month, day and year
						         $birthDate = explode("-", $applicant["birth_date"]);
						         //get age from date or birthdate
						         $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y")-$birthDate[0])-1):(date("Y")-$birthDate[0]));
						         echo $age;
			            	?></td>

			            <td style="vertical-align:middle; text-align:center;"><?php
			            		if($applicant["sex"] == 1)
			            			echo "Hombre";
			            		else
			            			echo "Mujer";
			            	?> </td>
					-->
			            <td  style="vertical-align:middle; width:20%;text-align:center;">				            
							<a class="btn" href="<?php echo "mailto:".$applicant["email"] ?>">
								<i class="icon-envelope icon-white"></i>					
							</a>
							<a class="btn" href="#">
								<i class="icon-file icon-white"></i>					
							</a>
						</td>

						<td style="vertical-align:middle; text-align:center;" >
							<?php

							echo'<input id="'.$applicant["id"].'" value="'.$applicant["id"].'"  name="selected[]" type="checkbox">';
							echo'<p style="display: none;" id="'.$i.'" >'.$applicant["email"].'</p>';


							?>
						</td>
		            </tr>    
              	<?php 
              	$i=$i+1;
              	}
            }
        	?>
          </tbody>
        </table>
		<div class="space4"></div>
		<div class="row">
			<a class="btn btn-info pull-right"  style="margin-left:10px;" href="#"><i style="margin-top: 3px; margin-right: 3px;" class="icon-off icon-white"></i>Finalizar Concurso</a>
			<a class="btn btn-info pull-right" href="<?php echo "mailto: ".$mailto_all; ?>"><i style="margin-top: 3px; margin-right: 3px;" class="icon-envelope icon-white"></i>Todos</a>
			<div class="space4"></div>
		</div>	
	</div>
</div>



