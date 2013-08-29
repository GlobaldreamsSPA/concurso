<script src="<?php echo base_url()?>js/highcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/highcharts.data.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/highcharts.exporting.js" type="text/javascript"></script>
<link href="<?php echo base_url()?>style/jquery.dataTables.css" rel="stylesheet">
<script src="<?php echo base_url()?>js/jquery.dataTables.min.js" type="text/javascript"></script>

<script type="text/javascript">

$(function () {
    $('#container').highcharts({
        data: {
            table: document.getElementById('table')
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
});

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
			<h1>Respuestas de la Trivia</h1>					
		</div>
		
		<div class="space2"></div>
		
		<div class="row" style="text-align:center; margin-bottom: 10px;">
			<ul class="breadcrumb" style=" background-color: transparent !important;  font-size:21px; ">
				  <li><a href="<?php echo HOME.'/hunter/casting_list' ?>">Concursos</a><span class="divider">/</span></li>
				  <li><a href="<?php echo HOME.'/hunter/casting_detail/'.$id_casting ?>"><?php echo $name_casting; ?></a> <span class="divider">/</span></li>
				  <li class="active">Respuestas</li>
			</ul>		
		</div>	

		<div class="row" style="margin-top:15px; left:0 !important;">
			<form style="margin-right: -6%;" class="row">
				<div class="span9">
					<div style="margin-left:4%;" class="styled span12">										
						<?php echo form_dropdown("question_id",$question_select,$selected_question,'id="question_id" style="width:100%;"') ?>
					</div>
					<div style="margin-left:4%; margin-top: 2%;" class="span1">										
						<div style="margin-top: 30%; font-weight: bold;">Filtros</div>
					</div>
					<div style="margin-left:3%; margin-top: 2%;" class="styled span3">										
						<?php echo form_dropdown("sex",$sex_select,$selected_sex,'id="sex" style="width:100%;"') ?>
					</div>
					<div style="margin-left:3%; margin-top: 2%; text-align:center;" class="span1">										
						<div style="margin-top: 5%; font-weight: bold;">Rango Edad</div>
					</div>
					<div style="margin-left:3%; margin-top: 2%;" class="styled span3">										
						<?php echo form_dropdown("from_age",$from_age_select,$selected_from_age,'id="from_age" style="width:100%;"') ?>
					</div>
					<div style="margin-left:3%; margin-top: 2%;" class="styled span3">										
						<?php echo form_dropdown("to_age",$to_age_select,$selected_to_age,'id="to_age" style="width:100%;"') ?>
					</div>
				</div>
				<div style="margin-left:2%; height: 20%;" class="styled span3">
					<button style="margin-top: 8%;" type="submit" class="btn btn-info">Actualizar Resultados</button>
				</div>
			</form>

			<div class="space2"></div>
			

			<?php 
				switch ($question_type[$selected_question]) {
					case 'select':
					case 'multiselect':
			?>
						<div class="row">
							<div class="span4" style="margin-left:4% !important;"> 
								<table id="table" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th style="text-align: center;">Opción</th>
											<th style="text-align: center;">Repeticiones</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											foreach ($options as $option){
										?>
												<tr>
													<td style="text-align: center; vertical-align: middle;"><?php echo $option["option"] ?></td>
													<td style="text-align: center; vertical-align: middle;"><?php echo $option["counter"] ?></td>
												</tr>
										<?php	
											} 
										?>
									</tbody>
								</table>
							</div>
							<div class="span8" style="margin-left:4% !important; margin-right: -2%;">
								<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
							</div>	
						</div>

						<div class="space2"></div>						
			<?php
						break;

					case 'text':			
			?>
						<div style="margin-left: 1px;" class="row">
							<table id="tblData" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th style="text-align: center;">Respuestas</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										foreach ($answers as $answer){
									?>
											<tr>
												<td style="text-align: center; vertical-align: middle;"><?php echo $answer["answer"] ?></td>
											</tr>
									<?php	
										} 
									?>
								</tbody>
							</table>
						</div>

						<div class="space2"></div>	

			<?php
						break;
					
					default:
						break;
				}
			?>
		</div>
	</div>
</div>