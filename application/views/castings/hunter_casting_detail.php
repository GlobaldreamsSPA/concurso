<script src="<?php echo base_url()?>js/highcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/highcharts.data.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/highcharts.exporting.js" type="text/javascript"></script>

<script type="text/javascript">

$(function () {
    $('#date_graph').highcharts({
        data: {
            table: document.getElementById('date_table')
        },
        chart: {
            plotBackgroundColor: "#ECF0F1",
            plotBorderWidth: null,
            plotShadow: false,
            type: 'line'
        },
        title: {
            text: "Días v/s Postulaciones"
        },
        yAxis: {
        	min: 0,
        	title: {
                    text: 'Postulaciones'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
			valueSuffix: ' postulantes'
        }
    });

    $('#hour_graph').highcharts({
        data: {
            table: document.getElementById('hour_table')
        },
        chart: {
            plotBackgroundColor: "#ECF0F1",
            plotBorderWidth: null,
            plotShadow: false,
            type: 'line'
        },
        title: {
            text: "Hora v/s Postulaciones"
        },
        yAxis: {
        	min: 0,
        	title: {
                    text: 'Postulaciones'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
			valueSuffix: ' postulantes'
        }
    });



    $('#sex_graph').highcharts({
        data: {
            table: document.getElementById('sex_table')
        },
        chart: {
            plotBackgroundColor: "#ECF0F1",
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: ""
        },
        yAxis: {
            allowDecimals: false,
        }, 
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                  dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
            }
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'

        }
    });

    $('#age_graph').highcharts({
        data: {
            table: document.getElementById('age_table')
        },
        chart: {
            plotBackgroundColor: "#ECF0F1",
            plotBorderWidth: null,
            plotShadow: false,
            type: 'line'
        },
        title: {
            text: "Edad v/s Postulaciones"
        },
        yAxis: {
        	min: 0,
        	title: {
                    text: 'Postulaciones'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
			valueSuffix: ' postulantes'
        }
    });

    $('#tab-info').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
		$("#tab-hour").tab('hide');
		$("#tab-date").tab('hide');
		$("#tab-sex").tab('hide');
		$("#tab-age").tab('hide');
	});

    $('#tab-date').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
		$("#tab-hour").tab('hide');
		$("#tab-info").tab('hide');
		$("#tab-sex").tab('hide');
		$("#tab-age").tab('hide');
	});

	$('#tab-hour').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
		$("#tab-date").tab('hide');
		$("#tab-info").tab('hide');
		$("#tab-sex").tab('hide');
		$("#tab-age").tab('hide');

	});

	$('#tab-sex').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
		$("#tab-hour").tab('hide');
		$("#tab-date").tab('hide');
		$("#tab-info").tab('hide');
		$("#tab-age").tab('hide');
	});

	$('#tab-age').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
		$("#tab-sex").tab('hide');
		$("#tab-hour").tab('hide');
		$("#tab-date").tab('hide');
		$("#tab-info").tab('hide');
	});


	$(function() {
		$( ".accordion" ).accordion({active: false});
	});
});

</script>

<style>
	.ui-accordion-content
	{
		max-height: 207px !important;
	}

	ul#myTab li.active a
	{
		color: #3498DB !important;
		background-color: #ECF0F1 !important;
		font-weight: bold;
	}
</style>

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
			<h1> Detalle Concurso</h1>					
		</div>
		<div class="space2"></div>

		<div class="row" style="text-align:center; margin-bottom: 10px;">
			<ul class="breadcrumb" style=" background-color: transparent !important;  font-size:21px; ">
				  <li><a href="<?php echo HOME.'/hunter/casting_list' ?>">Concursos</a><span class="divider">/</span></li>
				  <li><?php echo $casting["title"]; ?></li>
			</ul>		
		</div>

		<div class="row">
			<div style="margin-left: 4%;" class="span6">
				<img style="margin-top:10px; height: 250px;" src="<?php echo $casting['full_image'] ?>">
			</div>
			<div style="margin-left: 2%;" class="span6">
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
				
				<p>
					Estado: <span class="label <?php echo $casting['label_color']; ?>"><?php echo $casting['status']; ?></span>
				</p>										
				
				<?php 
					if($casting["category_id"]==2) 
					{
				?>
						<p>
							Retorno clicks: <?php echo $casting['share_count']; ?>
						</p>
						<p>
							Alcance: <?php echo $casting['share_reach']; ?>
						</p>															
				<?php
					} 
				?>
				<p>
					Postulaciones/Meta :<?php echo $casting['applies']."/".$casting['max_applies'] ?>
				</p>

				<div class="progress" style="width:97% !important; height: 17px; border: 1px solid #95A5A6;">
				    <div class="bar <?php echo $casting["target_applies_color"]?>" style="width: <?php echo $casting["target_applies"]?>%; color:white !important; font-weight: 900	;"><?php echo $casting["target_applies"]?>%</div>
				</div>


			</div>
		</div>
		<div class="space2"></div>
		

		<ul class="nav nav-tabs" id="myTab">
			<li class="active"><a style="font-size: 15px !important;" id="tab-info" href="#info">Información Concurso</a></li>
			<li><a style="font-size: 15px !important;" id="tab-date" href="#date"> Dia / Post </a></li>
			<li><a style="font-size: 15px !important;" id="tab-hour" href="#hour"> Hora / Post </a></li>
			<li><a style="font-size: 15px !important;" id="tab-sex" href="#sex"> Sexo / Post</a></li>
			<li><a style="font-size: 15px !important;" id="tab-age" href="#age"> Edad / Post</a></li>
		</ul>
		 
		<div class="tab-content">
			<div class="tab-pane active" id="info">
				<div class="row accordion">
					<h3>Descripci&oacuten</h3>
					<div style="font-size:15px;">
						<?php echo  $casting['description']; ?>
					</div>
					<h3>Pasos del Concurso</h3>
					<div style="font-size:15px;">
						<?php echo  $casting['steps']; ?>
					</div>
					<h3>Bases</h3>
					<div style="font-size:15px;">
						<?php echo  $casting['bases']; ?>
					</div>
					<h3>Premios</h3>
					<div style="font-size:15px;">
						<?php echo  $casting['prizes_description']; ?>
					</div>
				</div>	
			</div>
			<div class="tab-pane" id="date">
				<div class="row">
					<table id="date_table" style="display:none;" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th style="text-align: center;">Fecha</th>
								<th style="text-align: center;">Repeticiones</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								if($date_table)
									foreach ($date_table as $date){
							?>
										<tr>
											<td style="text-align: center; vertical-align: middle;"><?php echo $date["date"] ?></td>
											<td style="text-align: center; vertical-align: middle;"><?php echo $date["number"] ?></td>
										</tr>
							<?php	
									} 
							?>
						</tbody>
					</table>
					<div id="date_graph" style="min-width: 47.8%; height: 400px; margin: 0 auto"></div>
				</div>
			</div>
			<div class="tab-pane" id="hour">
				<div class="row">
					<table id="hour_table" style="display: none;"class="table table-striped table-bordered">
						<thead>
							<tr>
								<th style="text-align: center;">Hora</th>
								<th style="text-align: center;">Repeticiones</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								if($hour_table)
									foreach ($hour_table as $hour){
								?>
										<tr>
											<td style="text-align: center; vertical-align: middle;"><?php echo $hour["hour"] ?></td>
											<td style="text-align: center; vertical-align: middle;"><?php echo $hour["number"] ?></td>
										</tr>
								<?php	
									} 
							?>
						</tbody>
					</table>
					<div id="hour_graph" style="min-width: 47.8%; height: 400px; margin: 0 auto"></div>
				</div>
			</div>
			<div class="tab-pane" id="sex">
				<div class="row">
					<table id="sex_table" style="display:none;" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th style="text-align: center;">Sexo</th>
								<th style="text-align: center;">Repeticiones</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								if($sex_table)
									foreach ($sex_table as $sex){
							?>
										<tr>
											<td style="text-align: center; vertical-align: middle;"><?php echo $sex["sex"] ?></td>
											<td style="text-align: center; vertical-align: middle;"><?php echo $sex["number"] ?></td>
										</tr>
							<?php	
									} 
							?>
						</tbody>
					</table>
					<div id="sex_graph" style="height: 400px; min-width: 46.8%; margin-left:2%;"></div>
				</div>
			</div>
			<div class="tab-pane" id="age">
				<div class="row">
					<table id="age_table" style="display: none;"class="table table-striped table-bordered">
						<thead>
							<tr>
								<th style="text-align: center;">Año Nacimiento</th>
								<th style="text-align: center;">Repeticiones</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								if($age_table)
									foreach ($age_table as $age){
								?>
										<tr>
											<td style="text-align: center; vertical-align: middle;"><?php echo $age["age"] ?></td>
											<td style="text-align: center; vertical-align: middle;"><?php echo $age["number"] ?></td>
										</tr>
								<?php	
									} 
							?>
						</tbody>
					</table>
					<div id="age_graph" style="min-width: 47.8%; height: 400px; margin: 0 auto"></div>
				</div>
			</div>
		</div>

		<div class="space2"></div>

		<div style="margin-right: -9%;" class="row">
			<div class="span3 <?php if ($casting["category_id"] == "3") echo "offset4"; elseif($casting["category_id"] == "1") echo "offset5"; else  echo "offset7"; ?>">
				<a class="btn btn-primary" href="<?php echo HOME.'/hunter/accepted_list/'.$casting["id"] ?>" ><i style="margin-top: 3px; margin-right: 3px;" class="icon-star"></i>Elegir Ganador</a>
			</div>
			<div class="span2">
				<a class="btn btn-primary" href="<?php echo HOME.'/hunter/edit_casting/'.$casting["id"] ?>"><i style="margin-top: 3px; margin-right: 3px;" class="icon-edit"></i>Editar</a>
			</div>
			<?php if ($casting["category_id"] == "3") 
				{
			?>
					<div class="span3">
						<a class="btn btn-primary" href="<?php echo HOME.'/hunter/question_responses/'.$casting["id"] ?>"><i style="margin-top: 3px; margin-right: 3px;" class="icon-question-sign"></i>Ver respuestas</a>
					</div>
			<?php 
				}elseif ($casting["category_id"] == "1") 
				{
			?>
					<div class="span2">
						<a class="btn btn-primary" href="<?php echo HOME.'/hunter/photo_list/'.$casting["id"] ?>"><i style="margin-top: 3px; margin-right: 3px;" class="icon-camera"></i> Fotos</a>
					</div>
			<?php 
				}	
			?>
		</div>
		<div class="space2"></div>
	</div>
</div>