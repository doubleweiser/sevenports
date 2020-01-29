<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" >
<meta name="viewport" id="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
<?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { if(get_option('mvp_favicon')) { ?><link rel="shortcut icon" href="<?php echo esc_url(get_option('mvp_favicon')); ?>" /><?php } } ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php if ( is_single() ) { ?>
<meta property="og:type" content="article" />
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
		<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'mvp-post-thumb' ); ?>
		<meta property="og:image" content="<?php echo esc_url( $thumb['0'] ); ?>" />
		<meta name="twitter:image" content="<?php echo esc_url( $thumb['0'] ); ?>" />
	<?php } ?>
<meta property="og:url" content="<?php the_permalink() ?>" />
<meta property="og:title" content="<?php the_title_attribute(); ?>" />
<meta property="og:description" content="<?php echo strip_tags(get_the_excerpt()); ?>" />
<meta name="twitter:card" content="summary">
<meta name="twitter:url" content="<?php the_permalink() ?>">
<meta name="twitter:title" content="<?php the_title_attribute(); ?>">
<meta name="twitter:description" content="<?php echo strip_tags(get_the_excerpt()); ?>">
<?php endwhile; endif; ?>
<?php } else { ?>
<meta property="og:description" content="<?php bloginfo('description'); ?>" />
<?php } ?>
<?php wp_head(); ?>
		<!-- Adicionando Javascript CEP -->
		 <script type="text/javascript" >

		 function limpa_formulário_cep() {
				//Limpa valores do formulário de cep.
				document.getElementById('cep').value=("");
				document.getElementById('endere_o').value=("");
				document.getElementById('bairro').value=("");
				document.getElementById('cidade').value=("");
				document.getElementById('uf').value=("");
				}
		// insere o conteudo no formulario
		function meu_callback(conteudo) {
			console.log(conteudo);
			if (!("erro" in conteudo)) {
				//Atualiza os campos com os valores.
				document.getElementById('cep_731').value=(conteudo.cep);
				document.getElementById('endere_o_731').value=(conteudo.logradouro);
				document.getElementById('bairro_731').value=(conteudo.bairro);
				document.getElementById('cidade_731').value=(conteudo.localidade);
				document.getElementById('uf_731').value=(conteudo.uf);
				} //end if.
			else {
				//CEP não Encontrado.
				limpa_formulário_cep();
				alert("CEP não encontrado.");
			}
		}

		function pesquisacep(valor) {

			//Nova variável "cep" somente com dígitos.
			var cep = valor.replace(/\D/g, '');

			//Verifica se campo cep possui valor informado.
			if (cep != "") {

				//Expressão regular para validar o CEP.
				var validacep = /^[0-9]{8}$/;

				//Valida o formato do CEP.
				if(validacep.test(cep)) {

					//Preenche os campos com "..." enquanto consulta webservice.
					document.getElementById('cep_4001').value="...";
					document.getElementById('rua_4001').value="...";
					document.getElementById('bairro_4001').value="...";
					document.getElementById('cidade_4001').value="...";
					document.getElementById('uf_4001').value="...";

		   			//Cria um elemento javascript.
					var script = document.createElement('script');

					//Sincroniza com o callback.
					script.src = '//viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

					//Insere script no documento e carrega o conteúdo.
					document.body.appendChild(script);

				} //end if.
				else {
					//cep é inválido.
					limpa_formulário_cep();
					alert("Formato de CEP inválido.");
				}
			} //end if.
			else {
				//cep sem valor, limpa formulário.
				limpa_formulário_cep();
			}
		};

		</script>
		<!-- Adicionando Javascript temina cep-->
</head>
<body <?php body_class(''); ?>>
	<?php get_template_part('fly-menu'); ?>
	<div id="mvp-site" class="left relative">
		<div id="mvp-search-wrap">
			<div id="mvp-search-box">
				<?php get_search_form(); ?>
			</div><!--mvp-search-box-->
			<div class="mvp-search-but-wrap mvp-search-click">
				<span></span>
				<span></span>
			</div><!--mvp-search-but-wrap-->
		</div><!--mvp-search-wrap-->
		<?php if(get_option('mvp_wall_ad')) { ?>
			<div id="mvp-wallpaper">
				<?php if(get_option('mvp_wall_url')) { ?>
					<a href="<?php echo esc_url(get_option('mvp_wall_url')); ?>" class="mvp-wall-link" target="_blank"></a>
				<?php } ?>
			</div><!--mvp-wallpaper-->
		<?php } ?>
		<div id="mvp-site-wall" class="left relative">
			<?php if(get_option('mvp_header_leader')) { ?>
				<?php global $post; $mvp_post_layout = get_option('mvp_post_layout'); $mvp_post_temp = get_post_meta($post->ID, "mvp_post_template", true); if ( ( ! $mvp_post_temp && $mvp_post_layout == 'Template 5' && is_single() ) || ( ! $mvp_post_temp && $mvp_post_layout == 'Template 6' && is_single() ) || ( $mvp_post_temp == "global" && $mvp_post_layout == 'Template 5' && is_single() ) || ( $mvp_post_temp == "global" && $mvp_post_layout == 'Template 6' && is_single() ) || ( $mvp_post_temp == "temp5" && is_single() ) || ( $mvp_post_temp == "temp6" && is_single() ) ) { } else { ?>
				<div id="mvp-leader-wrap">
					<?php $leader_ad = get_option('mvp_header_leader'); if ($leader_ad && ! is_404()) { echo html_entity_decode($leader_ad); } ?>
				</div><!--mvp-leader-wrap-->
				<?php } ?>
			<?php } ?>
			<div id="mvp-site-main" class="left relative">
			<header id="mvp-main-head-wrap" class="left relative">
				<?php $mvp_nav_layout = get_option('mvp_nav_layout'); if( $mvp_nav_layout == "1" ) { ?>
					<nav id="mvp-main-nav-wrap" class="left relative">
						<div id="mvp-main-nav-small" class="left relative">
							<div id="mvp-main-nav-small-cont" class="left">
								<div class="mvp-main-box">
									<div id="mvp-nav-small-wrap">
										<div class="mvp-nav-small-right-out left">
											<div class="mvp-nav-small-right-in">
												<div class="mvp-nav-small-cont left">
													<div class="mvp-nav-small-left-out right">
														<div id="mvp-nav-small-left" class="left relative">
															<div class="mvp-fly-but-wrap mvp-fly-but-click left relative">
																<span></span>
																<span></span>
																<span></span>
																<span></span>
															</div><!--mvp-fly-but-wrap-->
														</div><!--mvp-nav-small-left-->
													

														<div class="mvp-nav-small-left-in">
															<div class="mvp-nav-small-mid left">
																<div class="mvp-nav-small-logo left relative">
																	<?php if(get_option('mvp_logo_nav')) { ?>
																		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url(get_option('mvp_logo_nav')); ?>" alt="<?php bloginfo( 'name' ); ?>" data-rjs="2" /></a>
																	<?php } else { ?>
																		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logos/logo-nav.png" alt="<?php bloginfo( 'name' ); ?>" data-rjs="2" /></a>
																	<?php } ?>
																	<?php if ( is_home() || is_front_page() ) { ?>
																		<h1 class="mvp-logo-title"><?php bloginfo( 'name' ); ?></h1>
																	<?php } else { ?>
																		<h2 class="mvp-logo-title"><?php bloginfo( 'name' ); ?></h2>
																	<?php } ?>
																</div><!--mvp-nav-small-logo-->
																<div class="mvp-nav-small-mid-right left">
																	<?php if (is_single()) { ?>
																		<div class="mvp-drop-nav-title left">
																			<h4><?php the_title(); ?></h4>
																		</div><!--mvp-drop-nav-title-->
																	<?php } ?>
																	<div class="mvp-nav-menu left">
																		<?php wp_nav_menu(array('theme_location' => 'main-menu')); ?>
																	</div><!--mvp-nav-menu-->
																</div><!--mvp-nav-small-mid-right-->
															</div><!--mvp-nav-small-mid-->
														</div><!--mvp-nav-small-left-in-->
													</div><!--mvp-nav-small-left-out-->
												</div><!--mvp-nav-small-cont-->
											</div><!--mvp-nav-small-right-in-->
											<div id="mvp-nav-small-right" class="right relative">
												<span class="mvp-nav-search-but fa fa-search fa-2 mvp-search-click"></span>
											</div><!--mvp-nav-small-right-->
										</div><!--mvp-nav-small-right-out-->
									</div><!--mvp-nav-small-wrap-->
								</div><!--mvp-main-box-->
							</div><!--mvp-main-nav-small-cont-->
						</div><!--mvp-main-nav-small-->
					</nav><!--mvp-main-nav-wrap-->
				<?php } else { ?>
					<nav id="mvp-main-nav-wrap" class="left relative">
						
						<div id="mvp-main-nav-bot" class="left relative">
							<div id="mvp-main-nav-bot-cont" class="left">
								<div class="mvp-main-box">
									<div id="mvp-nav-bot-wrap" class="left">
										<div class="mvp-nav-bot-right-out left">
											<div class="mvp-nav-bot-right-in">
												<div class="mvp-nav-bot-cont left">
													<div class="mvp-nav-bot-left-out">
														<div class="">
															<?php if(get_option('mvp_logo')) { ?>
																<a class="mvp-nav-logo-reg left " itemprop="url" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img itemprop="logo" src="<?php echo esc_url(get_option('mvp_logo')); ?>" alt="<?php bloginfo( 'name' ); ?>" data-rjs="2" /></a>
															<?php } else { ?>
																<a class="mvp-nav-logo-reg left " itemprop="url" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img itemprop="logo" src="<?php echo get_template_directory_uri(); ?>/images/logos/logo-large.png" alt="<?php bloginfo( 'name' ); ?>" data-rjs="2" /></a>
															<?php } ?>
															<?php if(get_option('mvp_logo_nav')) { ?>
																<a class="mvp-nav-logo-small left " href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url(get_option('mvp_logo_nav')); ?>" alt="<?php bloginfo( 'name' ); ?>" data-rjs="2" /></a>
															<?php } else { ?>
																<a class="mvp-nav-logo-small left " href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logos/logo-nav.png" alt="<?php bloginfo( 'name' ); ?>" data-rjs="2" /></a>
															<?php } ?>
															<?php if ( is_home() || is_front_page() ) { ?>
																<h1 class="mvp-logo-title"><?php bloginfo( 'name' ); ?></h1>
															<?php } else { ?>
																<h2 class="mvp-logo-title"><?php bloginfo( 'name' ); ?></h2>
															<?php } ?>
															
															<div class="mvp-nav-menu desktop left">
																<?php wp_nav_menu(array('theme_location' => 'main-menu')); ?>
															</div><!--mvp-nav-menu-->
														</div><!--mvp-nav-bot-left-in-->
													</div><!--mvp-nav-bot-left-out-->
												</div><!--mvp-nav-bot-cont-->
											</div><!--mvp-nav-bot-right-in-->
											<div class="mvp-nav-bot-left left relative">
															<div class="mvp-fly-but-wrap mvp-fly-but-click left relative">
																<span></span>
																<span></span>
																<span></span>
																<span></span>
															</div><!--mvp-fly-but-wrap-->
												<span class="mvp-nav-search-but fa fa-search fa-2 mvp-search-click"></span>
											</div><!--mvp-nav-bot-right-->
										</div><!--mvp-nav-bot-right-out-->
									</div><!--mvp-nav-bot-wrap-->
								</div><!--mvp-main-nav-bot-cont-->
							</div><!--mvp-main-box-->
						</div><!--mvp-main-nav-bot-->
					</nav><!--mvp-main-nav-wrap-->
				<?php } ?>
			</header><!--mvp-main-head-wrap-->
			<div id="mvp-main-body-wrap" class="left relative">
				<div class="topoNews">
					<div class="mvp-main-box relative">
						<div class="imgparceiro">
							<?php masterslider(1); ?> 
						</div>
						<div class="newsline">
							<?php if(function_exists('ditty_news_ticker')){ditty_news_ticker(747);} ?>
						</div>
					
					</div>
				</div>