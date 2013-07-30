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
			<h1> Detalle Casting</h1>					
		</div>
		<div class="space2"></div>

		<div class="row" style="text-align:center; margin-bottom: 10px;">
			<ul class="breadcrumb" style=" background-color: transparent !important;  font-size:21px; ">
				  <li><a href="<?php echo HOME.'/hunter/casting_list' ?>">Concursos</a><span class="divider">/</span></li>
				  <li><?php echo $casting["title"]; ?></li>
			</ul>		
		</div>

		<div class="row">
			<div class="span6">
				<img style="margin-top:10px; height: 250px;" src="<?php echo $casting['full_image'] ?>">
			</div>
			<div style="margin-left: 5%;" class="span6">
				<h2 id="profile" style="font-weight:bold;"> Información</h2>
				<div style="margin-top: 1%; margin-bottom: 5%;">
					<ul class="tags">
					<?php 
						echo "<li><a href='".HOME."/home?search_terms=&category=".$casting["category_id"]."&prize=' target='_blank'>".$casting["category"]."</a></li>";
						
						foreach ($casting["prizes"] as $id => $prize ) 
							if($prize!="")
							{
								echo "<li><a href='".HOME."/home?search_terms=&category=&prize=".$id."' target='_blank' >".$prize."</a></li>";
							}
					?>
					<ul>
				</div>

				<div class="space1"></div>	
				<p>
					El Casting empez&aacute;: <?php echo $casting['start_date'] ?>
				</p>
				<p>
					El Casting termina: <?php echo $casting['end_date'] ?>
				</p>
				<div class="space05"></div>
				
				<p>
					Estado: <span class="label <?php echo $casting['label_color']; ?>"><?php echo $casting['status']; ?></span>
				</p>										
				<div class="space1"></div>
																
				<p>
					Postulaciones/Meta :<?php echo $casting['applies']."/".$casting['max_applies'] ?>
				</p>
				<div class="progress" style="height: 17px;">
						<div class="bar <?php echo $casting["target_applies_color"];?>" style="width: <?php echo $casting["target_applies"];?>%; color:black !important;"><?php echo $casting["target_applies"];?>%</div>
				</div>


			</div>
		</div>
		<div class="space2"></div>

		<div class="row">
			<div class="span3">
				<a class="btn" href="<?php echo HOME.'/hunter/accepted_list/'.$casting["id"] ?>" ><i style="margin-top: 3px; margin-right: 3px;" class="icon-star"></i>Elegir Ganador</a>
			</div>
			<div class="span2">
				<a class="btn" href="<?php echo HOME.'/home/casting_detail/'.$casting["id"] ?>"><i style="margin-top: 3px; margin-right: 3px;" class="icon-search"></i>Previa</a>
			</div>
			<div class="span2">
				<a class="btn" href="<?php echo HOME.'/hunter/edit_casting/'.$casting["id"] ?>"><i style="margin-top: 3px; margin-right: 3px;" class="icon-edit"></i>Editar</a>
			</div>
		</div>
		<div class="space2"></div>
	</div>
</div>