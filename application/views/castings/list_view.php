<script type="text/javascript">
	var update_state_filter = function (event) 
	{
		
		var regExp1 = new RegExp(event.data.regexp); 
        var result = regExp1.exec($(event.data.target).attr("href"));
        var temp = (""+result).substr(0,(""+result).length - 2);
            
        result = temp + $(event.data.src).val() + "/";
		    
		$(event.data.target).attr("href",$(event.data.target).attr("href").replace(regExp1,result));

	};	
	
			
	$("#casting_status").change({regexp: '/[0-9]+/[0-3]/',target: '#filter_button',src: '#casting_status'},update_state_filter);
	$('#casting_status').trigger('change');

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
			<h1>Castings Publicados</h1>					
		</div>
		<div class="space1"></div>

		<form class="row">

			<div class="styled span8 offset1">
				<?php 
				echo form_dropdown('status', $status,$casting_state,"id='casting_status' style='width:100%'");
													
				?>
			</div>
			<div class="span2 offset1">
		    	<button href="<?php echo HOME."/hunter/casting_list/1/0/"?>" type="submit" class="btn btn-info">Actualizar</button>
			</div>
		</form>

		<?php foreach($castings as $casting){ ?>
		<div class="row">

			<div class="space1"></div>

			<div style="margin-left: 1%" class="row">
				<div class="span7">
					<a href="<?php echo site_url("hunter/casting_detail/".$casting['id']); ?>">
						<img style='height:100%; width: 100%;' src="<?php echo $casting['full_image'] ?>"/>
					</a>
				</div>
				<div class="space05"></div>
				<div style="margin-left: 5%; " class="span5">
														
					<div style="font-size: 25px;" class="row list-view-applies">						
						<?php echo $casting['title'] ?>
					</div>

					<div class="space2"></div>	


					<div class="row">
						<div class="span5">
							<label>Postulaciones</label>
							<p ><?php echo $casting['applies'] ?></p>

						</div>	
						<div style="margin-left: 3%;" class="span3">
							<label>Estado</label>
							<span class="label label-info"><?php echo $casting['status'] ?></span>
						</div>		
						<div style="margin-left: 3%;" class="span4">
							<label>Tiempo</label>

						<?php if($casting['days'] >0 ){ ?>
							<i class="icon-time"></i> <?php echo $casting['days'] ?> d&iacute;as
						<?php } ?>
						</div>					
					</div>

					<div class="space2"></div>	


					<div class="row">
						<a style="margin-left: 10%;" class="btn btn-info pull-right" href="<?php echo site_url("hunter/casting_detail/".$casting['id']); ?>" type="button"><i class="icon-zoom-in"></i> Ver detalle</a>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		
		<div class="row-fluid">
			<div class="space1"></div>
			<div class="pagination">  
			  <ul id="pagination_bt">
			  	  
			  	<li <?php if($page==1) echo "class='disabled'";?> ><a <?php if($page!=1) echo "href= '".base_url()."hunter/casting_list/".($page-1)."/".$casting_state."/'";?>>Prev</a></li>  
				<?php 
				$pag_size = 16; //se puede fijar una constante que lo maneje
				$margen = $pag_size/2;
				
				$begin_pag = $page - $margen;
				if($begin_pag < 0) $begin_pag = 1;
				
				$end_pag = $page + $margen;
				if($end_pag > $chunks) $end_pag = $chunks;
				
				
				for($i = $begin_pag; $i <= $end_pag; $i++) { ?>
					<li <?php if($page==$i) echo "class='disabled'";?> ><a <?php if($page!=$i) echo "href= '".base_url()."hunter/casting_list/".$i."?status=".$casting_state."'";?> > <?php echo $i; ?></a></li>  
				<?php } ?>
			    <li <?php if($page==$chunks) echo "class='disabled'";?> ><a <?php if($page!=$chunks) echo "href= '".base_url()."hunter/casting_list/".($page+1)."?status=".$casting_state."'";?>>Next</a></li>
			     
			  </ul>  
			</div>  
			<div class="space1"></div>	
		</div>	
	</div>
</div>