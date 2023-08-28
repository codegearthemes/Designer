<?php

$count = 0;
$categories = $settings['categories'];
if( !empty(  $categories ) && is_array( $categories ) ){
	$args = [
		'posts_per_page' => $settings['post_per_page'],
		'category_name' => implode( ',', $categories )
	];
}else{
	$args = [
		'posts_per_page' => $settings['post_per_page'],
	];
}

$query = new \WP_Query($args);
?>
<div class="block--posts-items">
    <div class="grid <?php echo esc_attr( $settings['layout'] ); ?>">
        <?php
            while ( $query->have_posts() ) : $query->the_post();
                $categories = get_the_category( get_the_ID() ); ?>
                    <div class="grid__item one-whole <?php if( $count == 0 ){ echo 'alpha-block '.$settings['alpha_style']; }else{ echo 'omega-block'; } ?>">
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-grid'); ?>>
                            <div class="content">
                                <?php if ( $settings['featured_image'] && has_post_thumbnail() && $count < 1 ): ?>
                                    <div class="image-left">
                                        <a href="<?php echo esc_url( get_permalink() ) ?>" title="<?php get_the_title(); ?>">
                                            <?php the_post_thumbnail( '850x' );  ?>
                                        </a>
                                    </div>
                                <?php elseif( $settings['featured_image_default'] && has_post_thumbnail() ): ?>
                                    <div class="image-left">
                                        <a href="<?php echo esc_url( get_permalink() ) ?>" title="<?php get_the_title(); ?>">
                                            <?php the_post_thumbnail( '250x' );  ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="entry-header">
                                    <?php
                                        if ( ! empty( $categories ) && $settings['show_cat'] && $count > 0 ) { ?>
                                            <div class="categories">
                                                <?php foreach( $categories as $category ) {
                                                    $meta = get_term_meta( $category->term_id, '_taxonomy_options', true ); ?>
                                                    <a class="entry-term" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'View all posts in %s', 'designer' ), $category->name ) ); ?>">
                                                        <?php echo esc_html( $category->name ); ?>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                            <?php
                                        }elseif( !empty( $categories ) && $settings['show_cat'] ) { ?>
                                            <div class="categories">
                                                <?php foreach( $categories as $category ) {
                                                    $meta = get_term_meta( $category->term_id, '_taxonomy_options', true ); ?>
                                                    <a class="entry-term" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'View all posts in %s', 'designer' ), $category->name ) ); ?>">
                                                    <?php echo esc_html( $category->name ); ?></a>
                                                <?php } ?>
                                            </div>
                                            <?php
                                        }
                                        the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );
                                    ?>
                                    <?php if( $settings['date'] || $settings['author'] ): ?>
                                        <div class="meta-data">
                                            <?php
                                                if( $settings['author'] && $count < 1 )
                                                \Designer\Includes\Helper::instance()->author(); ?>
                                            <?php
                                                if( $settings['date'] )
                                                \Designer\Includes\Helper::instance()->posted_on();
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php
                $count++;
            endwhile;
        wp_reset_postdata(); ?>
    </div>
</div>
