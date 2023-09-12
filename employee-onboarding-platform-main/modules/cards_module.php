<?php 
$mode = get_sub_field('mode');
$post_type_name = get_sub_field('post_type_name');
$posts = get_sub_field('select_posts');
?>

<div class="px-16 py-6 mt-8 grid md:grid-cols-3 gap-10 space-x-0">
    <?php
    if($mode == 'manual'){
        foreach($posts as $post){
            $post_title = wp_trim_words( $post->post_title , 20 , '...' );
            // $post_type = $post->post_type;
            $post_content = $post->post_content;
            $post_authorId = $post->post_author;    
            $post_date_default = $post->post_date;
            $post_date_string = strtotime($post_date_default);
            $post_date = date('d/m/Y', $post_date_string);
            $author = get_the_author_meta('display_name',$post_authorId);
            $post_description = wp_trim_words( $post_content , 20 , '...' );
            $post_permalink = get_permalink($post->ID);
            $post_image = get_the_post_thumbnail_url($post->ID);
            ?>
    
        <div class="bg-white overflow-hidden min-w-[320px] mx-auto" style="border-radius: 5%; box-shadow: 3px 3px 3px 3px #E0E0E0; max-height: 550px;">
            <!-- <a href="<?php echo $post_permalink ?>"> -->
                <div class="relative" style="height: 200px; margin-top: 12px;">
                    <img class="px-6 absolute w-full h-full object-cover rounded-lg" style="top: 10px; border-radius: 12%;" src="<?php echo $post_image ?>" alt="">
                </div>    
                    <br>
                    <!-- <h3 class="uppercase p-2 ml-4 bg-cyan-500 shadow-lg shadow-cyan-500/50 text-white w-32 text-center rounded-full"><?php echo $post_type  ?></h3> -->
                <div class="m-4">
                    <p class="font-bold text-xl" style="margin-left: 10px;"><?php echo $post_title ?></p>
                    <br>
                    <p class="font-semibold text-gray-500" style="margin-left: 10px; font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif"><?php echo $post_description ?></p>
                    <br>
                <div class="flex items-center space-x-2 mr-4">     
                <div>
                    <p class="text-xs text-gray-500" style="margin-left: 10px; margin-top: -100px; padding-top: 90px;">By: <?php echo $author ?>, <?php echo $post_date ?></p>
                </div>
                </div>
                </div>
            </a>
        </div>
    
    <?php
    }
    
    }else{
        $args = array(
            'post_type' => $post_type_name, // Replace with your post type
            'post_status' => 'publish',
            'numberposts' => -1,
            // Add any other arguments you need
        );
        
        $posts = get_posts($args);
        foreach($posts as $post){
            $post_title = wp_trim_words( $post->post_title , 20 , '...' );
            $post_type = $post->post_type;
            $post_content = $post->post_content;
            $post_authorId = $post->post_author;    
            $post_date_default = $post->post_date;
            $post_date_string = strtotime($post_date_default);
            $post_date = date('d/m/Y', $post_date_string);
            $author = get_the_author_meta('display_name',$post_authorId);
            $post_description = wp_trim_words( $post_content , 20 , '...' );
            $post_permalink = get_permalink($post->ID);
            $post_image = get_the_post_thumbnail_url($post->ID);
            ?>
    
        <div class="bg-white rounded overflow-hidden drop-shadow-2xl min-w-[320px]">
            <a href="<?php echo $post_permalink ?>">
                    <img class="w-full h-40 sm:h-60 object-cover" src="<?php echo $post_image ?>" alt="">
                    <br>
                    <!-- <h3 class="uppercase p-2 ml-4 bg-cyan-500 shadow-lg shadow-cyan-500/50 text-white w-32 text-center rounded-full"><?php echo $post_type  ?></h3> -->
                <div class="m-4">
                    <p class="font-bold text-xl"><?php echo $post_title ?></p>
                    <br>
                    <p><?php echo $post_description ?></p>
                    <br>
                <div class="flex items-center space-x-2 mr-4">     
                <div>
                    <p class="text-xs text-gray-500 mt-1 pt-24">By: <?php echo $author ?>, <?php echo $post_date ?></p>
                </div>
                </div>
                </div>
            </a>
        </div>
        <?php
    }
}
    ?>
    </div>