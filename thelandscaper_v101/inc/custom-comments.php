<?php
/**
 * Custom template tags for this theme.
 *
 * @package The Landscaper
 */

if ( ! function_exists( 'thelandscaper_comment' ) ) :
    function thelandscaper_comment( $comment, $args, $depth ) {
        
        $GLOBALS['comment'] = $comment;
        switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' :
        ?>
        
        <li class="post pingback">
            <p><?php esc_html_e( 'Pingback:', 'the-landscaper-wp' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( '(Edit)', 'the-landscaper-wp' ), ' ' ); ?></p>
        
        <?php
                break;
            default :
        ?>
        
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
    		<div class="comment-avatar"><?php echo get_avatar( $comment, 70 ); ?></div>

    		<?php if ( $comment->comment_approved == '0' ) : ?>
    			<em><?php esc_html__( 'Your comment is awaiting moderation.', 'the-landscaper-wp' ); ?></em>
    			<br />
    		<?php endif; ?>
    	 
    		<div class="comment-inner">
                <div class="comment-header">
                    <div class="author-link">
                        <?php the_author_link(); ?>
                    </div>
                    <div class="comment-time">
                        <time datetime="<?php comment_time( 'c' ); ?>"><?php printf( esc_html__( '%1$s at %2$s', 'the-landscaper-wp' ), get_comment_date(), get_comment_time() ); ?></time>
                    </div>
                    <?php edit_comment_link( esc_html__( '(Edit)', 'the-landscaper-wp' ), ' ' ); ?>
                </div>
                <div class="comment-content">
                    <?php comment_text(); ?>
                </div>
                <div class="comment-actions">
                    <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div>
    		</div>
    	</li>

        <?php
                break;
        endswitch;
    }
endif;