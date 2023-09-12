<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php wp_title(); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/dist/assets/css/style.css" rel="stylesheet">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> style="background-color: rgba(200, 201, 217, 0.28);">

<header class="header" style="position: relative; width: 100%; z-index: 999">
	<?php if (is_user_logged_in()) { ?>
        <div class="font-bold flex" style="left: 10px; top: 0; width: 100%; height: 60px; position: fixed; background-color: white; border-radius: 30px; box-shadow: 3px 3px 3px  #E0E0E0; margin-left: 25px;">
           <div class="container mx-auto flex justify-between fb-responsive-header">
               <div class="user">
	               <?php $current_user = wp_get_current_user(); ?>
                   <a href="<?php echo home_url() ?>">
                       <h3>
                           Hello, <?php echo esc_html($current_user->display_name)?>
                       </h3>
                   </a>
               </div>
               <div class="searchbar-container sm:ml-5 ml-0">
                   <form action="<?php echo esc_url(home_url('/')); ?>" method="get">
                       <button class="search-btn"
                               type="submit"
                               style="background: none; border: none; position: absolute;  cursor: pointer;"
                       >
                           <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#696969">
                               <path d="M21.71 20.29l-4.88-4.88C18.44 14.19 19 12.64 19 11c0-4.42-3.58-8-8-8S3 6.58 3 11s3.58 8 8 8c1.64 0 3.19-.56 4.41-1.49l4.88 4.88c.39.39 1.02.39 1.41 0 .38-.39.38-1.03-.01-1.42zM11 18c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6z"/>
                           </svg>
                       </button>
                       <input type="search"
                              name="s"
                              placeholder="What are you looking for?"
                              autocomplete="off"
                              aria-label="Search"
                              class="pr-3 pl-10 font-semibold rounded-full border-2 search-input"
                       >
                   </form>
               </div>
           </div>
        </div>
        <div>
			<?php get_sidebar();?>
        </div>
        <div>
            <?php
            if (!is_singular('team') && !is_page_template('user-profile.php') && !is_search()) {
                include('team_template.php');
            }
            ?>
        </div>
	<?php } else { ?>
        <!-- Code to show when the user is not logged in -->
	<?php } ?>
</header>

<script>
    document.querySelector('input[name="s"]').addEventListener('paste', function(event) {
        const pasteData = event.clipboardData.getData('text/plain');
        if ((pasteData.includes('http://') || pasteData.includes('https://')) || pasteData.includes('www') || pasteData.includes('www')) {
            event.preventDefault();
            alert('Links are not allowed!');
        }
    });

    document.querySelector('form').addEventListener('submit', function(event) {
        const inputData = document.querySelector('input[name="s"]').value;
        if ((inputData.includes('http://') || inputData.includes('https://')) || (inputData.includes('www') || inputData.includes('www'))) {
            event.preventDefault();
            alert('Links are not allowed in the search bar!');
        }
    });

</script>
