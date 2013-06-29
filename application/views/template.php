<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">	


	<?php 
		if(isset($about))
		{ 
	?>
			<title>La pagina de concursos chilena, conoce Ganando .cl</title>
			<meta name="description" content="Concursa y gana muchos premios. Bienvenido a Ganando .cl">
			<meta name="keywords" content="de concursos, a concursos, concurso de, sobre concurso, concurso chile">
	<?php
		} 
		elseif(isset($company))
		{
	?>
			<title>Publicidad para tu negocio o pyme - Ganando .cl </title>
			<meta name="description" content="Publicidad para tu negocio o pyme  - Ganando .cl">
			<meta name="keywords" content="publicidad, pyme, negocio, marketing, emprendedor">
	
	<?php
		}
		else
		{
	?>
			<title>Todos los concursos para ganar - Ganando .cl </title>
			<meta name="description" content="La pagina de concursos chilena, donde podrás participar por muchos premios. Conoce Ganando.cl">
			<meta name="keywords" content="ganar ganar, gana, concurso, concursos, como ganar">
	<?php
		}
	?>

	<meta property="og:title" content="Ganando.cl - ¡Donde todos Ganan!"/>
	<meta property="fb:app_id" content="374106952676336"/>
	<meta property="og:type" content="website" />
	<meta property="og:description" content="La nueva plataforma online que llevará a toda la gente con talento al éxito, la revolución ya comienza!."/>
	<meta property="og:image" content="<?php echo HOME.'/img/logo.png'?>"/>


	<link rel="icon" type="image/png" href="<?php echo HOME ?>/favicon.ico">

	<link href="<?php echo base_url()?>style/main.css" rel="stylesheet">
	<link href="<?php echo base_url()?>style/bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url()?>style/flat-ui.css" rel="stylesheet">
	<link href="<?php echo base_url()?>style/jquery.dataTables.css" rel="stylesheet">
	<link href="<?php echo base_url()?>style/jquery.cleditor.css" rel="stylesheet">
	<link href="<?php echo base_url()?>style/uniform.default.css" rel="stylesheet"/>
	<link href="<?php echo base_url()?>style/chosen.css" rel="stylesheet"/>
	<link href="<?php echo base_url()?>style/jquery.countdown.css" rel="stylesheet"/>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />


</head>

<body>
 	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>	
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script> 
 	<script src="<?php echo base_url()?>js/chosen.jquery.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/bootstrap.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/jquery.cleditor.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/jquery.uniform.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/jquery.dataTables.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/chosen.jquery.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/jquery.ba-resize.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>js/jquery.countdown.js" type="text/javascript"></script>
	
	<div class="wrapper">	
		<div id="fb-root"></div>
		<div class="navbar navbar-fixed-top" id="headercontent">
			<?php
						
				$id = $this->session->userdata('id');

				if($id)
				{
					$user = $this->session->userdata('name')." ".$this->session->userdata('last_name');
				}
				
				/*verificacion ususario hunter*/
				$id_h = $this->session->userdata('logged_in');	

				if($id_h)
				{
					$name = $this->session->userdata('logged_in');
					$name= $name["name"];
				}
			?>
			<div class="navbar-inner" style="background-color: #E67E22">
			    <div class="container" >
			    	<a rel="nofollow" class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                </a>
			    	<a class="brand" style="background-color:#D35400; border-radius: 0; height:40px; margin-left:1% !important; position: absolute; color: #ECF0F1" title="Volver a la P&aacute;ina Principal" href="<?php echo HOME?>"> 	<img style="margin-top:-15px;"src="<?php echo HOME."/img/logogif.gif"; ?>" /></a>

					<div style="margin-left:300px;" class="nav-collapse collapse navbar-responsive-collapse">
	                    <ul class="nav">
							<?php
								echo "<li>".anchor('home', 'Home')."</li>";
								echo "<li>".anchor('home/what_is', '¿Que es?')."</li>";
								if(!$id && !$id_h)
									echo "<li>".anchor('home/company', 'Empresas')."</li>";
	             	   		?>
	             	   </ul>

	             	   <ul class="nav pull-right">
		            	   	<?php
								if($id)
								{
									echo "<li>".anchor('user', $user)."</li>";
									echo "<li>".anchor('user/logout','Cerrar sesi&oacuten')."</li>";

								}
								
								elseif ($id_h) 
								{	
									echo "<li>".anchor('hunter', $name)."</li>";
									echo "<li>".anchor('hunter/logout','Cerrar sesi&oacuten')."</li>";						
								}
							
								if(!$id && !$id_h)
								{ 
								?>
									<li class="dropdown">
	                        			<a rel="nofollow" href="#" class="dropdown-toggle" data-toggle="dropdown">Iniciar sesi&oacute;n <b class="caret"></b></a>
			                        <ul class="dropdown-menu">
			                     	<?php    
										echo "<li>".anchor('user/fb_login', "<img style='margin-left:7px;' src='".HOME."/img/fb-login.png' />")."</li>";
			                        ?>
			                        </ul>
			                      </li>
								<?php 
								}
							?>	
						</ul>             
	                </div>
			    </div>	
			</div>
			<div class="color_line"></div>
		</div>

		<?php $this->load->view($content,$inner_args); ?>

		<div class="push"></div>
	</div>
	<footer>
		<div class="color_line"></div>
		<div class="space2"></div>
		<div class"row">
			<div class="span12"><p style="color: #ECF0F1;">GlobalDreams SPA | Publica tus concursos <a rel="nofollow" href="<?php echo base_url();?>home/login_hunter">con nosotros</a> | Lee los <a rel="nofollow" href="<?php echo base_url();?>docs/terms.pdf">t&eacuterminos y condiciones</a> | <a rel="nofollow" href="mailto:contacto@viddon.com">Cont&aacutectanos</a></p></p></div>
		</div>
		<div class="row">
			<div class="span12">
				<div class="row">
						<div class="span11 offset1" style="margin-top: -3px;">
							<p style="margin-left: 30px; text-decoration: none; color: #ECF0F1;" class="second">Ganando &copy; 2013 | Todos los derechos reservados | 
							<a style="margin-left: 15 px;" href="https://twitter.com/ViddonCom" target=”_blank”><img style="width: 25px; height: 25px;" src="<?php echo base_url(); ?>img/twitter-logo.png"/></a>
							<a href="https://www.facebook.com/ganandochile" target=”_blank”> <img style="width: 25px; height: 25px;" src="<?php echo base_url(); ?>img/fb-logo.png"/></a>
							<a rel="nofollow" style="top:6px;" class="fb-like" data-href="https://www.facebook.com/ganandochile" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></a>				
							</p>
						</div>
				</div>
			</div>
		</div>
		<div class="space2"></div>
	</footer>

	<script type="text/javascript">
	      
	    if($(".chzn-select").length > 0)
			$(".chzn-select").chosen({no_results_text: "No se encontraron resultados"});
		
		if($("#datatables").length > 0)
      		$(document).ready(function() {
			    $('#datatables').dataTable({
		    		"sPaginationType": "full_numbers"
				});
			});
		
      	if($("#contestmodal").length > 0)
      	{
	      	$("a[data-target=#contestmodal]").click(function(ev) {
			    ev.preventDefault();
			    var target = $(this).attr("href");

			    // load the url and show modal on success
			    $("#contestmodal .modal-body").load(target, function() { 
			         $("#contestmodal").modal("show"); 
			    });
			});

			jQuery(".modal-backdrop, #contestmodal .close, #contestmodal .btn").live("click", function() {
	        jQuery("#contestmodal").remove();
			});
		}

      	if($("#playermodal").length > 0)
      	{
	      	$("a[data-target=#playermodal]").click(function(ev) {
			    ev.preventDefault();
			    var target = $(this).attr("href");

			    // load the url and show modal on success
			    $("#playermodal .modal-body").load(target, function() { 
			         $("#playermodal").modal("show"); 
			    });
			});

			jQuery(".modal-backdrop, #playermodal .close, #playermodal .btn").live("click", function() {
	        jQuery("#playermodal iframe").attr("src", null);
			});
		}


		if($("#dp1").length > 0)
			$(function(){
				$("#dp1").datepicker({ dateFormat: "dd/mm/yy" });
			});
		
		if($("#dp2").length > 0)
			$(function(){
				$("#dp2").datepicker({ dateFormat: "dd/mm/yy" });
			});

		if($(".carousel").length > 0)
			$('.carousel').carousel({
		  		interval: 7000
			});
		
	
		if($(".chzn-select").length > 0)
			$(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true});
   		

			
	    
		(function(d, s, id) 
		{
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

		!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
    	
    	if($("#grow").length > 0 && $("#variable").length > 0  )
		{
			if($('#variable').height() >= $('#grow').height() )
			{
				$('#grow').css({
					'height': $('#variable').outerHeight()
				});
			    	
			    jQuery('#variable').bind( 'resize', function(e) {
						  
					$('#grow').css({
						    'height': $('#variable').outerHeight()
					});
				});
			}else
			{
				$('#variable').css({
					'height': $('#grow').outerHeight()
				});
			    	
			    jQuery('#grow').bind( 'resize', function(e) {
						  
					$('#variable').css({
						    'height': $('#grow').outerHeight()
					});
				});
			}
		}

		$('.menu').css({
			'height': $('#headercontent').outerHeight()
		});
			    	

		
		if($(".chosen_filter").length > 0)
		{
			var function_clean_select_all = function () 
			{
				
				 $("option",this).each(function () {
					if(this.selected && this.value == -1)
					{
						$(this).parent().children("option").each(function () {
							if($(this).val() == -2)
								$(this).prop('selected', false);
							else
								$(this).prop('selected', true);
						});
						$(this).prop('selected', false);
						$(this).parent().trigger('liszt:updated');
						return false;
					}
					
					if(this.selected && this.value == -2)
					{
						$(this).parent().children("option").each(function () {
							$(this).prop('selected', false);
						});
						$(this).prop('selected', false);
						$(this).parent().trigger('liszt:updated');
						return false;
					}
					
			      });
			};

			$(".chosen_filter").change(function_clean_select_all);
			$('.chosen_filter').trigger('change');

		}



		var update_chosen_filter = function (event) 
		{
			
			var regExp1 = new RegExp(event.data.regexp); 
	        var result = regExp1.exec($(event.data.target).attr("href"));
	        var temp = (""+result).substr(0,(""+result).length - 1);
	        temp = temp.substr(0,temp.lastIndexOf('/')+1)
	        var uri="";
			
			$("option",this).each(function () {
				if(this.selected)
			    	uri= uri + this.value +"_";
			});
			     
			uri= uri.substr(0,uri.length - 1);
			if(uri=="")
				uri=-2;
	        result = temp + uri + "/";
			    
			$(event.data.target).attr("href",$(event.data.target).attr("href").replace(regExp1,result));

		};	

		/* filtro en home/casting list */
		if($("#filter").length > 0)
		{
			$("#filter").change({regexp: '/[0-9]+/[0-9_-]+/',target: '#filter_button'},update_chosen_filter);
			$('#filter').trigger('change');
		}
		
		var update_state_filter = function (event) 
		{
			
			var regExp1 = new RegExp(event.data.regexp); 
	        var result = regExp1.exec($(event.data.target).attr("href"));
	        var temp = (""+result).substr(0,(""+result).length - 2);
	            
	        result = temp + $(event.data.src).val() + "/";
			    
			$(event.data.target).attr("href",$(event.data.target).attr("href").replace(regExp1,result));

		};	
		
		/* filtro en hunter/casting_list*/
		if($("#casting_status").length > 0)
		{				
			$("#casting_status").change({regexp: '/[0-9]+/[0-3]/',target: '#filter_button',src: '#casting_status'},update_state_filter);
			$('#casting_status').trigger('change');
		}



		if($("iframe").attr('src').indexOf("youtube") >= 0){
			$("iframe").each(function(){
			  var ifr_source = $(this).attr('src');
			  var wmode = "&wmode=opaque";
			  $(this).attr('src',ifr_source+wmode);
			});
		}
			    	    
   
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-42063032-1', 'ganando.cl');
		ga('send', 'pageview');

	</script>
</body>