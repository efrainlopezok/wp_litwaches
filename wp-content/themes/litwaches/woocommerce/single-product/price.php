<?php
/**
 * Single Product Price
 *
 *
 */

global $product;
?>

<?php the_title( '<h2 class="product_title entry-title">', '</h2>' ); ?>
<p class="price"><?php echo $product->get_price_html(); ?></p>
