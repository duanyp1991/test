<?php get_header(); ?>

								
                    <!-- Inner Content Section starts here -->
                    <div id="inner_content_section">

                        
						<?php if(!of_get_option('show_magpro_slider_page') || of_get_option('show_magpro_slider_page') == 'true') : ?>  
                            <?php 
								if ( of_get_option('magpro_slider') ) {
									$destro_dslider = of_get_option('magpro_slider');
								} else {
									$destro_dslider = 'cheader';
								}
								get_template_part( 'slider', $destro_dslider ); 
							?>                
                        <?php endif; ?>                                               
                        
                        	             
                        <!-- Main Content Section starts here -->
                        <div id="main_content_section">
                

										<?php if (have_posts()) : ?>
											<?php while (have_posts()) : the_post(); ?>
												<!-- Actual Post starts here -->
												<div <?php post_class('actual_post') ?> id="post-<?php the_ID(); ?>">
                                                	<div class="ta_meta_container">
													<div class="actual_post_title_page">
														<h2><?php the_title(); ?></h2>
													</div>
													</div>
													<div class="post_entry">

														<div class="entry">
															<?php the_content(__('<span>Continue Reading >></span>', 'Destro')); ?>
															<div class="clear"></div>
															<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'Destro' ) . '</span>', 'after' => '</div>' ) ); ?>																				
														</div>

														
													
													</div>
                                                    
												</div>
												<!-- Actual Post ends here -->		
												<?php comments_template(); ?>
												<?php endwhile; ?>
												<?php endif; ?>
                
                
                        </div>	
                        <!-- Main Content Section ends here -->

                        <!-- Sidebar Section starts here -->
                        <?php get_sidebar(); ?> 	
                        <!-- Sidebar Section ends here -->





                    </div>	
                    <!-- Inner Content Section ends here -->
							
			<?php get_footer(); ?>								
									

							
								
									
