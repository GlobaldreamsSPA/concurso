	<link href="<?php echo base_url()?>style/jquery.dataTables.css" rel="stylesheet">
	<script src="<?php echo base_url()?>js/jquery.dataTables.min.js" type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function() {
		    $('#tblData').dataTable();
		} );
	</script>


	<div class="row-fluid">		
	<div class="span3 user-profile-left">
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
    
    <div style="padding-left:3%;" class="span8 offset1 user-profile-right">
    		
		<row>
			<div class="span10">
				<h1> Selección de Ganador(es)</h1>					
			</div>
			<div class="span1" style="margin-left: -1%;">
				<a class="btn" href="<?php echo "mailto: ".$mailto_all; ?>">
					<i class="icon-envelope icon-white"></i>					
					Todos                                            
				</a>
			</div>
			<div class="span1" style="margin-left: 6%;">
				<a class="btn" href="#">
					<i class="icon-off icon-white"></i>					
					Cerrar                                            
				</a>
			</div>		
			<ul class="breadcrumb" style="margin-left:20px; background-color: transparent !important; margin-top:73px !important; font-size:15px; ">
				  <li><a href="<?php echo HOME.'/hunter/casting_list' ?>">Concursos</a><span class="divider">/</span></li>
				  <li><a href="<?php echo HOME.'/hunter/casting_detail/'.$id_casting ?>"><?php echo $name_casting; ?></a> <span class="divider">/</span></li>
				  <li class="active">Participantes</li>
			</ul>								
		</row>



				

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
			            <?php
			            	$image_profile = GALLERY.$applicant["image_profile"];

			            	$file = realpath(LOCAL_GALLERY.$applicant["image_profile"]);
			            	
			            	if($applicant["image_profile"] != "" && file_exists($file))
			            	{
			            		$filesize = filesize($file);
			            		
			            		if($filesize == 0)
			            		{
			            			$image_profile = GALLERY.'generic.png';
			            		}
			            	}
			            	else
			            	{
			            		$image_profile = GALLERY.'generic.png';
			            	}
			            ?>
			            	<img style="max-width: 80px; max-height:80px;" src="<?php echo $image_profile ?>"/>
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
		
	</div>
</div>
<div class="row-fluid">	
	<div class="space4"></div>	
</div>