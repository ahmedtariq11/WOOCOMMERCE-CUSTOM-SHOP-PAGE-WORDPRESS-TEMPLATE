<?php
/* Template Name: Custom Shop */
get_header();
?>
  <section class="clearfix">
    <div class="container">
      <h4>Products</h4>
        <div class="product-gallery">
          <div class="row">
            <?php
              // WP_Query arguments
              $args = array(
              'post_type' => 'product',
              'post_status' => 'publish',
              'posts_per_page' => -1,
              'tax_query'=>array(      // The taxonomy query
              array(
              'taxonomy'  => 'product_cat',
              'terms'     => array(18,19),
              'operator' => 'NOT IN',
              )
              )
              );
              // The Query
              $query = new WP_Query( $args );
              // The Loop
              if ( $query->have_posts() ) {
              while ( $query->have_posts() ) {
              $query->the_post();
              global $product;
              $product = get_product( get_the_ID() ); 
              ?>
              <div class="col-md-3 col-sm-4">
                <div class="product-img">
                   <div class="product-thumb">
                    <a href="<?php echo get_the_permalink(); ?>" class="product-detail">
                      <?php echo get_the_post_thumbnail(); ?>
                    </a>
                  </div>
                  <div class="product-price">
                    <strong>$<?php echo get_post_meta( get_the_ID(), '_regular_price', true); ?></strong>
                    <?php
                    $products_ids_array = array();
                    foreach( WC()->cart->get_cart() as $cart_item ){
                      $products_ids_array[] = $cart_item['product_id'];
                    }
                    if(in_array(get_the_ID(), $products_ids_array)) {
                      echo '<a href="'.site_url().'/cart/">View Cart</a>';
                    } else {
                      echo '<a href="'.$product->add_to_cart_url().'">Add to Cart</a>';
                    }
                    ?>
                  </div>
                  <h6><?php echo get_the_title(); ?></h6>
                </div>
              </div>
              <?php
              }
              } else {
              // no posts found
              }
              // Restore original Post Data
              wp_reset_postdata();
            ?>                                    
        </div>
      </div>
    </div>
  </section>
<?php get_footer(); ?>
