<?php
$author_data =  get_the_author_meta('description',get_query_var('author') );
$author_bio_avatar_size = 120;
if($author_data !=''):
?>
    <div class="author mt-80 mb-40">
        <div class="author-img">
            <a href="<?php print esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>"><?php print get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size,'','',array('class'=>'media-object img-circle') ); ?></a>
        </div>
        <div class="author-text">
            <h3><a href="<?php print esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>"><?php print get_the_author(); ?></a></h3>
            <p><?php the_author_meta( 'description' ); ?> </p>
            <div class="author-icon">
                <a href="<?php print esc_attr(get_the_author_meta( 'profile_fb_url')); ?>" target="_blank" ><i class="fa fa-facebook-f"></i></a>
                <a href="<?php print esc_attr(get_the_author_meta( 'profile_twitter_url'));?>" target="_blank" ><i class="fa fa-twitter"></i></a>
                <a href="<?php print esc_attr(get_the_author_meta( 'profile_google_url')); ?>" target="_blank" ><i class="fa fa-google-plus"></i></a>
                <a href="<?php print esc_attr(get_the_author_meta( 'profile_instagram_url')); ?>" target="_blank" ><i class="fa fa-linkedin"></i></a>
                <a href="<?php print esc_attr(get_the_author_meta( 'profile_behance_url')); ?>" target="_blank" ><i class="fa fa-behance-square"></i></a>
            </div>
        </div>
    </div>

<?php endif; ?>