<?php
/**
 * Frontpage Slider Template Part
 *
 * @package The Landscaper
 */
?>

<div class="jumbotron carousel slide" id="jumbotron-fullwidth" data-ride="carousel" <?php printf( 'data-interval="%s"', get_field( 'auto_cycle' ) ? get_field( 'slide_interval' ) : 'false' ); ?>>
    <div class="carousel-inner">

        <a class="carousel-control left" href="#jumbotron-fullwidth" role="button" data-slide="prev"><i class="fa fa-caret-left"></i></a>
        <a class="carousel-control right" href="#jumbotron-fullwidth" role="button" data-slide="next"><i class="fa fa-caret-right"></i></a>

        <?php 
            $i = -1;
            while ( have_rows( 'slide' ) ) : 
                the_row();
                $i++;

                // Get the url for the img src
                $slide_image = wp_get_attachment_image_src( get_sub_field( 'slidebg_image' ), 'thelandscaper-home-slider-m' );

                // Get the srcset code
                $slide_image_srcset = thelandscaper_srcset_sizes( get_sub_field( 'slidebg_image' ), array( 'thelandscaper-home-slider-s', 'thelandscaper-home-slider-m', 'thelandscaper-home-slider-l' ) );
            ?>

            <div class="item <?php echo 0 === $i ? 'active' : ''; ?>">
                <img src="<?php echo esc_url( $slide_image[0] ); ?>" width="<?php echo esc_attr( $slide_image[1] ); ?>" height="<?php echo esc_attr( $slide_image[2] ); ?>" srcset="<?php echo esc_html( $slide_image_srcset ); ?>" sizes="100vw" alt="<?php echo esc_attr( strip_tags( get_sub_field( 'slide_heading' ) ) ); ?>">
               
                <?php if ( get_field( 'slide_captions' ) ) : ?>
                    <div class="container">
                        <div class="carousel-text <?php echo esc_attr( get_field( 'caption_align' ) ); ?>">
                            <?php if( get_sub_field( 'slide_top_heading' ) ) : ?>
                                <div class="carousel-topheading"><?php the_sub_field( 'slide_top_heading' ); ?></div>
                            <?php endif; ?>
                            <?php if( get_sub_field( 'slide_heading' ) ) : ?>
                                <div class="carousel-heading"><h1><?php the_sub_field( 'slide_heading' ); ?></h1></div>
                                <?php endif; ?>
                            <?php if( get_sub_field( 'slide_text' ) ) : ?>
                                <div class="carousel-content"><?php the_sub_field( 'slide_text' ); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        
        <?php endwhile; ?>

        <?php if( get_field( 'slide_indicators' ) === true ) : ?>
            <div class="container">
                <div class="col-xs-12">
                    <ol class="carousel-indicators">
                        <?php
                        $i = -1;
                        while ( have_rows( 'slide' ) ) : 
                            the_row();
                            $i++;
                        ?>
                            <li data-target="#jumbotron-fullwidth" data-slide-to="<?php echo esc_attr( $i ); ?>"<?php echo 0 === $i ? ' class="active"': ''; ?>></li>
                        <?php endwhile; ?>
                    </ol>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>