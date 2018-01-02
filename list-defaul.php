<?php
global $options, $is_author;
$show_author = isset($options['show_author']) && $options['show_author']=='0' ? 0 : 1;
$img_right = isset($options['list_img_right']) && $options['list_img_right']=='1' ? 1 : 0;
$margin = $img_right ? 'style="margin-right: 0;"': 'style="margin-left: 0;"' ;
?>
<li class="item<?php echo $img_right ? ' item2':'';?>">
    <?php $has_thumb = get_the_post_thumbnail(); if($has_thumb){ ?>
    <div class="item-img">
        <a href="<?php the_permalink();?>" title="<?php echo esc_attr(get_the_title());?>" target="_blank">
            <?php the_post_thumbnail(); ?>
        </a>
        <?php
        $category = get_the_category();
        $cat = $category?$category[0]:'';
        if($cat){
        ?>
        <a class="item-category" href="<?php echo get_category_link($cat->cat_ID);?>" target="_blank"><?php echo $cat->name;?></a>
        <?php } ?>
    </div>
    <?php } ?>
    <div class="item-content<?php echo isset($is_author) && ($is_author || $post->post_status =='draft' || $post->post_status =='pending' ) ? ' item-edit' : '';?>"<?php echo ($has_thumb?'':$margin);?>>
        <?php if(isset($is_author) && ($is_author || $post->post_status =='draft' || $post->post_status =='pending' )){?>
            <a class="edit-link" href="<?php echo get_edit_link($post->ID);?>" target="_blank">编辑</a>
        <?php } ?>
        <h2 class="item-title">
            <a href="<?php the_permalink();?>" title="<?php echo esc_attr(get_the_title());?>" target="_blank">
                <?php if(isset($is_author) && $post->post_status=='draft'){ echo '<span>【草稿】</span>'; }else if(isset($is_author) && $post->post_status=='pending'){ echo '<span>【待审核】</span>'; }?>
                <?php the_title();?>
            </a>
        </h2>
        <div class="item-excerpt">
            <?php the_excerpt(); ?>
        </div>
        <div class="item-meta">
            <?php if($show_author && function_exists('um_get_core_page')){ ?>
            <div class="item-meta-li author">
                <?php
                $author = get_the_author_meta( 'ID' );
                um_fetch_user( $author );
                $author_url = um_user_profile_url();
                ?>
                <a data-user="<?php echo $author;?>" target="_blank" href="<?php echo $author_url; ?>" class="avatar">
                    <?php echo get_avatar( $author, 60 );?>
                </a>
                <a class="nickname" rel="nofollow noopener" href="<?php echo $author_url; ?>" target="_blank"><?php echo um_user('display_name'); ?></a>
            </div>
            <?php } ?>
            <span class="item-meta-li date"><?php echo format_date(get_post_time( 'U', false, $post ));?></span>
            <?php
            if(function_exists('the_views')) {
                $views = intval(get_post_meta($post->ID, 'views', true));
            ?>
            <span class="item-meta-li views" title="阅读数"><i class="fa fa-eye"></i> <span class="data"><?php echo $views; ?></span></span>
            <?php } ?>
            <span class="item-meta-li likes" title="点赞数"><i class="fa fa-thumbs-up"></i> <span class="data"><?php $likes = get_post_meta($post->ID, 'wpcom_likes', true); echo $likes?$likes:0;?></span></span>
            <a class="item-meta-li comments" href="<?php the_permalink();?>#comments" target="_blank" title="评论数"><i class="fa fa-comment"></i> <span class="data"><?php echo get_comments_number();?></span></a>
            <span class="item-meta-li hearts" title="喜欢数"><i class="fa fa-heart"></i> <span class="data"><?php $favorites = get_post_meta($post->ID, 'wpcom_favorites', true); echo $favorites?$favorites:0;?></span></span>
        </div>
    </div>
</li>
<?php if(is_home()||is_category()||is_archive()) do_action('wpcom_echo_ad', 'ad_flow');?>