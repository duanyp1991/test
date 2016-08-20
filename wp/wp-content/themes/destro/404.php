<?php get_header(); ?>

								
                    <!-- Inner Content Section starts here -->
                    <div id="inner_content_section">

                        
						<?php if(!of_get_option('show_magpro_slider_home') || of_get_option('show_magpro_slider_home') == 'true') : ?>  
                            <?php 
								if ( of_get_option('magpro_slider') ) {
									$dslider = of_get_option('magpro_slider');
								} else {
									$dslider = 'cheader';
								}
								get_template_part( 'slider', $dslider ); 
							?>                
                        <?php endif; ?>                        
                        
                        	             
                        <!-- Main Content Section starts here -->
                        <div id="main_content_section_search">
                

							<div class="fouroh">
                            	<h2><?php _e('Not Found!', 'Destro') ?></h2>
                                <p><?php _e('You are looking for something that is not here. Please use the seach form below.', 'Destro') ?></p>
                                <div class="fourohsearch">
                                	<?php get_search_form(); ?>
                                </div>
                                
                                
                            </div>
	

                
                
                        </div>	
                        <!-- Main Content Section ends here -->






                    </div>	
                    <!-- Inner Content Section ends here -->
							
			<?php get_footer(); ?>								
									

							
								
									
