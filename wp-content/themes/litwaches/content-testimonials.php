<?php
/**
 * Genarate the home testimonials section
 *
 *
 */

$testimonials   = get_field('testimonials_global', 'option');
$test_title     = $testimonials['test_title'];
$test_subtitle  = $testimonials['test_subtitle'];
$list_testimonials  = $testimonials['list_testimonials'];
if($list_testimonials):
?>
<section class="testi-section <?php echo is_home()? '' : 'no-home'; ?>">
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
