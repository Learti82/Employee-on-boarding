<?php get_header();

define( 'THEME_URI', get_template_directory_uri() );

$author_id  = get_query_var( 'author' );
$author     = get_user_by( 'id', $author_id );
$avatar_uri = get_avatar_url( $author );

$cover              = get_user_meta( $author->ID, 'cover_photo', true );
$profileImage       = get_user_meta( $author->ID, 'profile_image', true );
$author_name        = $author->user_firstname;
$author_lastName    = $author->last_name;
$author_displayName = $author->display_name;
$author_login       = $author->user_login;
$location           = get_user_meta( $author->ID, 'location', true );
$author_bio         = $author->description;
$author_email       = $author->user_email;
$author_website     = $author->user_url;
$author_registered  = $author->user_registered;
$author_position    = $author->position;


?>

<style>
    body {
        overflow-x: hidden;
    }

    @media (min-width: 830px) {
        .content-area {
            width: 75%;
        }

        .author-card {
            width: 50%;
        }
    }

    @media (min-width: 830px) and (max-width: 1350px) {
        .author-card {
            width: 80%;
        }

        .content-area {
            margin-left: 8rem !important;
        }
    }

    @media (max-width: 830px) {
        .content-area {
            margin-left: 6.8rem !important;
            margin-right: 1rem;
        }

        .author-card {
            width: 100%;
        }

        .author-profile-img {
            width: 90px !important;
            height: 90px !important;
        }

        .author-card-body {
            left: 0 !important;
            top: 0 !important;
        }
    }

    @media (max-width: 520px) {
        .profile-image {
            height: 180px !important;
        }

        .author-registered-date {
            transform: translateX(-40%) !important;
        }

        .author-position {
            position: static !important;
            margin-top: 1rem;
            margin-left: -4px;
            margin-bottom: .5rem;
            display: flex;
        }

        .content-area {
            position: relative;
            top: 8rem;
            margin-top: 0 !important;
        }


    }


    @media (min-width: 1351px) and (max-width: 1527px) {
        .author-position {
            left: 40% !important;
        }
    }

    @media (min-width: 831px) and (max-width: 940px) {
        .author-position {
            left: 40% !important;
        }
    }

    .content-area {
        margin-left: 8rem;
        margin-top: 10rem;
    }

    .author-card {
        border-radius: 2rem;
        box-shadow: 0 3px 15px #d3d3d3;
        background: #fff;
        margin: 0 auto;
    }

    .author-card-body {
        padding: 2rem;
        position: relative;
        left: 6rem;
        top: -1rem;
    }


    .profile-image {
        width: 100%;
        height: 300px;
        margin-bottom: 2rem;
    }

    .author-cover-img {
        width: 100%;
        height: 100%;
        border-radius: 2rem 2rem 0 0;
        cursor: pointer;
    }

    .author-profile-img {
        width: 110px;
        height: 110px;
        border: 1px solid #fcfcfc;
        border-radius: 50%;
        position: relative;
        top: -3.6rem;
        left: 1.5rem;
        cursor: pointer;
    }

    .push-content {
        margin-left: 12rem;
    }

    .author-usr-profile {
        color: #444;
    }

    .author-location,
    .author-email,
    .author-website {
        display: flex;
        margin-bottom: .7rem;
    }

    .author-location > img,
    .author-email > img,
    .author-website > img {
        margin-right: .5rem;
    }

    .author-location > a:hover,
    .author-email > a:hover,
    .author-website > a:hover {
        color: #777;
    }

    .author-fullname {
        font-size: 20px;
        font-weight: 600;
    }

    .author-registered-date {
        font-size: 15px !important;
        font-weight: lighter !important;
        position: relative;
        top: 0;
        left: 50%;
        transform: translateX(-14%);
    }

    .author-position {
        position: relative;
        top: -5.5rem;
        left: 50%;
        display: flex;
        align-items: center;
    }

    /* Modals */

    .author-cover-modal-hidden, .author-profile-modal-hidden {
        display: none;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        background-color: rgba(0, 0, 0);
        z-index: 999;
    }

    .author-modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    .author-modal-close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .author-modal-close:hover,
    .author-modal-close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }


</style>


<div id="primary" class="content-area push-content">
    <main id="main" class="site-main" role="main">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/content', get_post_format() );
			endwhile;
			the_posts_navigation();
		else :
			get_template_part( 'template-parts/content', 'none' );

			?>
            <div class="author-usr-profile">
                <div class="profile-infos">
                    <div class="author-card">
                        <div class="profile-image">
							<?php if ( $cover ) : ?>
                                <img src="<?php echo $cover ?>" alt="Cover" class="author-cover-img"
                                     id="authorCoverImgOpen">
							<?php else: ?>
                                <div class="author-cover-img" style="background-color: #bae6ff"></div>
							<?php endif; ?>

							<?php if ( $profileImage ) : ?>
                                <img src="<?php echo $profileImage; ?>" alt="Profile img" class="author-profile-img"
                                     id="authorProfileImgOpen">
							<?php else: ?>
                                <img src="<?php echo $avatar_uri; ?>" alt="Profile img" class="author-profile-img"
                                     id="authorProfileImgOpen">
							<?php endif; ?>
                        </div>

                        <div class="author-card-body">
                            <h2 class="author-fullname">
								<?php echo $author_displayName; ?>
                            </h2>
                            <h3 class="author-login" style="margin-bottom: 1rem; margin-top: -5px">
								<?php echo $author_login; ?>
                            </h3>
							<?php if ( $author_bio ) : ?>
                                <p class="author-bio">
									<?php echo $author_bio; ?>
                                </p>
							<?php endif; ?>
							<?php if ( $author_position ) : ?>
                                <p class="author-position">
                                    <img src="<?php echo THEME_URI . '/images/id-card.png'; ?>" alt="Position">
									<?php echo $author_position; ?>
                                </p>
							<?php endif; ?>
							<?php if ( $location ) : ?>
                                <p class="author-location">
                                    <img src="<?php echo THEME_URI . '/images/location.png' ?>" alt="Location">
									<?php echo $location; ?>
                                </p>
							<?php endif; ?>
                            <p class="author-email">
                                <img src="<?php echo THEME_URI . '/images/mail.png' ?>" alt="Image">
                                <a href="mailto:<?php echo $author_email; ?>">
									<?php echo $author_email; ?>
                                </a>
                            </p>
							<?php if ( $author_website ) : ?>
                                <p class="author-website">
                                    <img src="<?php echo THEME_URI . '/images/world-wide-web.png' ?>" alt="Image">
                                    <a href="<?php echo $author_website; ?>" target="_blank">
										<?php echo $author_displayName; ?>
                                    </a>
                                </p>
							<?php endif; ?>
                        </div>

                        <div class="author-registered-date">
                            <p>
                                <span>Member since:</span>
								<?php echo date( 'j F Y', strtotime( $author_registered ) ) ?>
                            </p>

                        </div>
                    </div>
                </div>
            </div>

            <div id="authorCoverModal" class="author-cover-modal-hidden">
                <span class="author-modal-close" id="authorCoverModalClose">&times;</span>
                <img class="author-modal-content" id="authorCoverImg" src="<?php echo $cover ?>">
            </div>

            <div id="authorProfileModal" class="author-profile-modal-hidden">
                <span class="author-modal-close" id="authorProfileModalClose">&times;</span>
                <img class="author-modal-content" id="authorProfileImg"
                     src="<?php echo $profileImage ? $profileImage : $avatar_uri ?>">
            </div>
		<?php endif; ?>
    </main><!-- #main -->
</div><!-- #primary -->

<script>
    // Get the modal
    var authorCoverModal = document.getElementById("authorCoverModal");
    var authorProfileModal = document.getElementById("authorProfileModal");

    // Get the image and insert it inside the modal
    var authorCoverImg = document.getElementById("authorCoverImgOpen");
    var authorProfileImg = document.getElementById("authorProfileImgOpen");

    authorCoverImg.onclick = function () {
        authorCoverModal.style.display = "flex";
    }

    authorProfileImg.onclick = function () {
        authorProfileModal.style.display = "flex";
    }

    // Get the <span> element that closes the modal
    var authorCoverSpan = document.getElementById("authorCoverModalClose");
    var authorProfileSpan = document.getElementById("authorProfileModalClose");

    // When the user clicks on <span> (x), close the modal
    authorCoverSpan.onclick = function () {
        authorCoverModal.style.display = "none";
    }

    authorProfileSpan.onclick = function () {
        authorProfileModal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == authorCoverModal) {
            authorCoverModal.style.display = "none";
        }

        if (event.target == authorProfileModal) {
            authorProfileModal.style.display = "none";
        }
    }
</script>
<?php get_footer(); ?>
