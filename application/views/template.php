<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">	


	<?php 
		
		if(isset($about))
		{ 
	?>
			<title>La pagina de concursos chilena, conoce Ganando .cl</title>
			<meta name="description" content="Concursa y gana muchos premios. Bienvenido a Ganando.cl">
			<meta name="keywords" content="de concursos, a concursos, concurso de, sobre concurso, concurso chile">
	<?php
		} 
		elseif(isset($company))
		{
	?>
			<title>Publicidad para tu negocio o pyme - Ganando .cl </title>
			<meta name="description" content="Podrás realizar publicidad  y marketing para tu negocio a bajo costo, especialmente dirigido a emprendedores o pymes - Ganando .cl">
			<meta name="keywords" content="publicidad, pyme, negocio, marketing, emprendedor">
	
	<?php
		}
		else
		{
	?>
			<title>Todos los concursos para ganar - Ganando .cl </title>
			<meta name="description" content="La nueva pagina de concursos chilena, donde podrás participar por muchos premios. Conoce Ganando.cl">
			<meta name="keywords" content="ganar ganar, gana, concurso, concursos, como ganar">
	<?php
		}
	?>

	<meta property="og:title" content="Ganando.cl - ¡Donde todos Ganan!"/>
	<meta property="fb:app_id" content="458089044282863"/>
	<meta property="og:type" content="website" />
	<meta property="og:description" content="La nueva pagina de concursos chilena, donde podrás participar por muchos premios. Conoce Ganando.cl"/>
	<meta property="og:image" content="<?php echo HOME.'/img/share.png'?>"/>


	<link rel="icon" type="image/png" href="<?php echo HOME ?>/favicon.ico">

	<link href="<?php echo base_url()?>style/main.css?v=1.1" rel="stylesheet">
	<link href="<?php echo base_url()?>style/bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url()?>style/flat-ui.css" rel="stylesheet">
	<link href="<?php echo base_url()?>style/chosen.css" rel="stylesheet"/>
	<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/jquery-ui.css" rel="stylesheet"/>


</head>
<body>
	<div id="postulation-result" class="modal hide fade in">
	<div class="modal-header">
	<a class="close" rel="nofollow" data-dismiss="modal"><i class="icon-remove"></i></a> 
	</div>
	<div class="modal-body">
	<h4>Ganando.cl</h4>
	<p><?php if(isset($success_message)) echo $success_message; ?></p>              
	</div>
	<div class="modal-footer">
	<a href="#" rel="nofollow" class="btn btn-primary" data-dismiss="modal">Cerrar</a>
	</div>
	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>	
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script> 
	<script src="<?php echo base_url()?>js/chosen.jquery.min.js" type="text/javascript"></script>
	<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>	
	<script src="<?php echo base_url()?>js/jquery.countdown.js" type="text/javascript"></script>
	
	<div class="wrapper">	
		<div id="fb-root"></div>
		<div id="header">
			<div style="text-align:center; margin-top:2%;">
				<a title="Volver a la P&aacute;ina Principal" href="<?php echo HOME.'/home'?>">
					<img src="<?php echo base_url().'img/logo.png'?>">
				</a>
			</div>
			<?php 
		
				if(isset($ganando_promo))
				{ 
			?>
					<div class="align-center">
						<div id="banner-container">
	
							<img src="<?php echo base_url().'img/home_header.png'?>">
							
							<div class="banner" id="left-banner">
								<a href="<?php echo HOME."/user/fb_login"?>">
									<img src="<?php echo HOME.'/img/bg1.png?v=1.1'?>"/>
								</a>
							</div>
							<div class="banner"  id="center-banner">
								<a href="#" onclick=" $('body,html').animate({ scrollTop: 500 }, 600); ">
									<img src="<?php echo HOME.'/img/bg2.png?v=1.1'?>"/>
								</a>

							</div>
							<div class="banner" id="right-banner">
								<a href="https://twitter.com/ganandocl" target="_blank" >
									<img src="<?php echo HOME.'/img/bg3.png?v=1.1'?>"/>
								</a>
							</div>
						</div>
					</div>
			<?php
				} 
			?>

			<div class="space2"></div>
			<div style="width: 75%; margin-left: 12.5%; margin-bottom: 0;" class="navbar">
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
				<div class="navbar-inner" style="border-radius:0; background-color: #E67E22; height: 40px;">
				    <div class="container">
	                    <ul class="nav">
	                    	<li class="left-triangle"></li>		
							<?php
								echo "<li>".anchor('home', 'Inicio')."</li>";
								echo "<li>".anchor('home/what_is', '¿Que es?')."</li>";
								if(!$id && !$id_h)
									echo "<li>".anchor('home/company', 'Empresas')."</li>";
	             	   		?>
	             	   </ul>

	             	   <ul class="nav pull-right">
		            	   	<?php
								if($id)
								{
									echo "<li>".anchor('user', "<span style='margin-right:10px; color: #3b5998;' class='fui-user'></span>".$user)."</li>";
									echo "<li>".anchor('user/logout','Cerrar sesi&oacuten')."</li>";

								}
								
								elseif ($id_h) 
								{	
									echo "<li>".anchor('hunter', "<span style='color: white;'>¡Bienvenido! </span>".$name)."</li>";
									echo "<li>".anchor('hunter/logout','Cerrar sesi&oacuten')."</li>";				
								}
							
								if(!$id && !$id_h)
								{   
									echo "<li>".anchor('user/fb_login', "<img style='margin-right:10px; margin-top: -5px; opacity: 0.92;' src='".HOME."/img/fb-login.png' /> Iniciar sesi&oacute;n"," id='fb-login' rel='nofollow' title='Iniciar sesión con facebook'")."</li>";
			                       
								}
							?>
							<li class="right-triangle"></li>		
						</ul>             
				    </div>
				</div>
			</div>
			<div style="height:1px; background: #E67E22;"></div>
		</div>

		<?php $this->load->view($content,$inner_args); ?>

		<div class="push"></div>
	</div>
</body>
<footer>
	<div class="color_line"></div>
	<div style="text-align: center;	background-color: #E67E22;" class="row">
		<div class="space1"></div>
		<div style="text-align: right; " class="span2">
			<img src="<?php echo HOME.'/img/footer_dude.png'; ?>" />
		</div>
		<div class="span4">
			<p style="color: white; margin: 0;">Es el nuevo portal donde podrás encontrar</p> 
			<p style="color: white; margin: 0;">muchos concursos entretenidos para participar</p>
			<p style="color: white; margin: 0;">¿Qué estas esperando?</p>
			<p style="color: white; margin: 0;">¡CONCURSA!</p>
		</div>
		<div class="span6">
			<p style="color: white; margin: 0;">Recibe noticias de nuestros concursos</p> 
			<p style="color: white; margin: 0;">y ve los sorteos en nuestras redes sociales</p>
			<div class="space05"></div>
			<a href="https://twitter.com/ganandocl" target=”_blank”><img style="width: 30px; height: 30px;" src="<?php echo base_url(); ?>img/social_container_t.png"/></a>
			<a style="margin-left: 15px;" href="https://www.facebook.com/ganandochile" target=”_blank”> <img style="width: 30px; height: 30px;" src="<?php echo base_url(); ?>img/social_container_f.png"/></a>
		</div>
	</div>
	<div style="background-color: #E67E22;" class="space1"></div>
	<div class="row" style="text-align: center; background-color: #d5741e;">
		<p style="line-height: 30px; margin: 0; text-decoration: none; color: #ECF0F1;" class="second"> Ganando &copy; 2013 | Publica tus concursos <a rel="nofollow" href="<?php echo base_url();?>home/company">con nosotros</a> | Lee los <a rel="nofollow"  target=”_blank” href="<?php echo base_url();?>docs/terms.pdf">t&eacuterminos y condiciones</a> | <a rel="nofollow" href="mailto:contacto@viddon.com">Cont&aacutectanos</a>
		</p>
	</div>
	<?php if(isset($success_message)){ ?>
		<script type="text/javascript">

		  $('#postulation-result').modal({
		    show: true
		  });
		</script>
	<?php } ?>
</footer>
<script type="text/javascript">
    

    if($(".chzn-select").length > 0)
		$(".chzn-select").chosen({no_results_text: "No se encontraron resultados"});
	


	$(function(){
		$("#dp1").datepicker({ dateFormat: "dd/mm/yy" });
	});

	$(function(){
		$("#dp2").datepicker({ dateFormat: "dd/mm/yy" });
	});
		    

	$('.menu').css({
		'height': $('#headercontent').outerHeight()
	});
		    	

	
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


		
	(function(d, s, id) 
	{
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-42063032-1', 'ganando.cl');
	ga('send', 'pageview');

</script>