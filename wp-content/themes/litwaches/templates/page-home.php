<?php
/**
* Template Name: Home Page
* Description: Used as a page template to show page contents, followed by a loop 
* through the Home page template
*/
/* # Home Page Block Sections
---------------------------------------------------------------------------------------------------- */
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_after_header', 'home_row_sections' , 2 );
function home_row_sections() {
    $home_hero = get_field('home_hero');
    $txt_content    = $home_hero['txt_content'];
    $button_1       = $home_hero['button_1'];
    $button_2       = $home_hero['button_2'];
    $bkg_image      = $home_hero['bkg_image']; 
    $list_of_sponsors = $home_hero['list_of_sponsors'];
    ?>
    <section class="home-hero align-self-center" style="background-image: url(<?php echo $bkg_image?>)">
        <div class="wrap ">
            <div class="home-hero-content text-center ">
                <?php echo $txt_content; ?>
                <div class="group-buttons">
                    <a href="<?php echo $button_1['url']?>" target="<?php echo $button_1['target']; ?>" class="btn btn-transparent-white"><?php echo $button_1['title']; ?></a>
                    <a href="<?php echo $button_2['url']?>" target="<?php echo $button_2['target']; ?>" class="btn btn-orange"><?php echo $button_2['title']; ?></a>
                </div>
            </div>
        </div>
        <?php if($list_of_sponsors): ?>
        <div class="sponsors">
            <div class="wrap">
                <div class="row">
                    <?php foreach ($list_of_sponsors as $row) {
                       ?>
                       <div class="col-c7">
                            <img src="<?php echo $row['sponsor_image']?>" alt="">
                        </div>
                       <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </section>
    <?php  
    $services = get_field('services');
    $serv_title             = $services['serv_title'];
    $serv_subtitle          = $services['serv_subtitle'];
    $list_of_services       = $services['list_of_services'];
    ?>
    <section id="home-services" class="home-services row-space">
        <div class="wrap">
            <header>
                <h2><?php echo $serv_title ?></h2>
                <p><?php echo $serv_subtitle?></p>
            </header>
            <div class="services row">
                <?php if($list_of_services):
                    foreach($list_of_services as $row){?>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="row">
                                <div class="col-3">
                                    <img src="<?php echo $row['serv_icon']?>" />
                                </div>
                                <div class="col-9">
                                    <?php echo $row['serv_text'] ?>
                                </div>
                            </div>
                        </div>
                <?php };endif;?>
            </div>
        </div>
    </section>
    <?php
    $home_video     = get_field('home_video');
    $video_title    = $home_video['video_title'];
    $video_content  = $home_video['video_content'];
    $video_desc     = $home_video['video_description'];
    $type_of_video  = $home_video['type_of_video']['value'];
    $mp4_url        = $home_video['mp4_url'];
    $webm_url       = $home_video['webm_url'];
    $youtube_url    = $home_video['youtube_url'];
    $vimeo_url      = $home_video['vimeo_url'];

    if($type_of_video === 'youtube') {
        $split = explode("v=", $youtube_url);
        if(sizeof($split) > 1) {
            $video_url = $split[1];
        }
        else {
            $video_url = $youtube_url;
        }
    }
    else if($type_of_video === 'vimeo') {
        $split = explode('video/', $video_url);
        if(sizeof($split) > 1) {
            $video_url = $split[1];
        }
        else {
            $video_url = $vimeo_url;
        }
    }

    ?>
    <section class="video-section">
        <div class="wrap">
	        <div class="row home-video-row">
	        	<div class="col-md-6 col-12">
	        		<div class="video-wach" 
                        data-video-widget="#show_video_modal" 
                        data-video="<?php echo $video_url;?>" 
                        data-type="<?php echo $type_of_video; ?>" 
                        data-avoid-bg="true">
	        			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/home-wach.png" alt="wach">
	        			<div class="c-play-video"></div>
	        		</div>
	        	</div>
	        	<div class="col-md-6 col-12">
	        		<div class="video-aside">
	        			<h3><?php echo  $video_title ?> </h3>
		        		<?php echo $video_content?>
	        		</div>
	        	</div>
	        </div>
          <?php if($video_desc): ?>
            <div class="video-section__description"><?php echo $video_desc; ?></div>
          <?php endif; ?>
        </div>
    </section>
    <!-- Play video modal -->
    <div class="modal fade c-modal video-modal" id="show_video_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <button class="close"><i class="icon-remove-sign"></i></button>
            <div class="video-wrapper">
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Play video modal -->

    <?php
    $home_slider = get_field('home_slider');
    $watches        = $home_slider['watches'];
    if($watches):
        ?>
    <section class="slider-section">
    	<div class="wrap">
    		<div class="home-wach-slider">
                <?php
                    foreach($watches as $row){
                    $watch_image    = $row['watch_image'];  
                     ?>
                        <div class="slide">
                            <img src="<?php echo $watch_image?>" alt="">
                        </div>
                <?php                  
            } 
            ?>
			</div>
    	</div>
    </section>
        <?php
    endif;
                      
    ?>
    <?php
    $testimonials   = get_field('testimonials_global', 'option');
    $test_title     = $testimonials['test_title'];
    $test_subtitle  = $testimonials['test_subtitle'];
    $list_testimonials  = $testimonials['list_testimonials'];
    if($list_testimonials):
        ?>
        <section class="testi-section">
    	<div class="wrap">
    		<header>
    			<h2><?php echo $test_title?></h2>
    			<p><?php echo $test_subtitle?></p>
    		</header>
    		
    		<div class="testimonial-slider">
                <?php
                foreach($list_testimonials as $row){?>
    			<div class="slide">
    				<img src="<?php echo $row['test_image']?>" alt="">
    				<blockquote><?php echo $row['test_content']?></blockquote>
    				<p><strong><?php echo $row['test_author']?></strong></p>
    			</div>
                <?php }?> 
    		</div>
    	</div>
    </section>
        <?php
    endif;
    ?>
    <?php
    $call_action = get_field('call_action');
    $call_title         =   $call_action['call_title'];
    $call_button        =   $call_action['call_button'];
    $call_image         =   $call_action['call_image'];
    ?>
    <section class="home-call-action " style="background-image: url('<?php echo  $call_image?>')">
        <div class="wrap row-space">
            <h2><?php echo $call_title ?></h2>
            <a href="<?php echo $call_button['url']?>" target="<?php echo $call_button['target']; ?>" class="btn btn-orange"><?php echo $call_button['title']; ?></a> 
        </div>
    </section>
    <?php
}

//* Remove .site-inner
add_filter( 'genesis_markup_site-inner', '__return_null' );
add_filter( 'genesis_markup_content-sidebar-wrap_output', '__return_false' );
add_filter( 'genesis_markup_content', '__return_null' );
add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );

genesis();