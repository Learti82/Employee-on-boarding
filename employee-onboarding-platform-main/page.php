<?php
get_header();
// Check if the flexible content field "Modules" exists and has rows
?>

<style>
    @media (max-width: 530px) {
        .sm-section {
            width: 80%;
            margin-left: 74px !important;
            padding: 0 1rem;
        }

    }

    @media (max-width: 930px) {
        .md-section {
            width: 90%;
            margin-left: 74px !important;
            padding: 0 1rem;
        }

        .md-section > .container {
            width: 90%;
            margin: 0 auto;
        }
    }

    @media (min-width: 930px) {
        .lg-section {
            width: 85%;
            margin-left: 8rem;
            padding: 0 1rem;
        }

        .lg-section > .container {
            width: 75%;
            margin: 0 auto;
        }
    }

    @media (min-width: 1300px) and (max-width: 1614px) {
        .lg-section {
            padding-right: 8rem;
        }
    }


</style>

<section class="page sm-section md-section lg-section mt-16">
    <div class="container">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				the_content();

				if ( have_rows( 'modules' ) ) {
					// Loop through the flexible content rows
					while ( have_rows( 'modules' ) ) {
						the_row();

						// Check if the current row is the "FAQ Module"
						if ( get_row_layout() === 'faq_module' ) {
							$faqTitle = get_sub_field( 'faq_title' );
							$faqItems = get_sub_field( 'faq_items' );

							// Display the FAQ module content
							if ( $faqItems ) {
								echo '<h2>' . esc_html( $faqTitle ) . '</h2>';
								echo '<div class="faq-module">';
								foreach ( $faqItems as $faqItem ) {
									echo '<div class="qa-container">';
									echo '<button class="accordion" data-expanded="false">';
									echo '<span class="plus" style="background-image: url(\'http://employee-onboarding.test/wp-content/uploads/2023/08/plus.png\')"></span>';
									echo '<span class="minus" style="background-image: url(\'http://employee-onboarding.test/wp-content/uploads/2023/08/minus.png\'); display: none;"></span>';
									echo esc_html( $faqItem['question'] );
									echo '</button>';
									echo '<div class="panel">';
									echo '<p>' . wp_kses_post( $faqItem['answer'] ) . '</p>';
									echo '</div>';
									echo '</div>';
								}
								echo '</div>';
							}
						} // Add more conditions for other flexible content layouts if needed
                        elseif ( get_row_layout() === 'cards_module' ) {
							// Code to handle cards module
						} elseif ( get_row_layout() === 'content_module' ) {
							// Code to handle content module
						} elseif ( get_row_layout() === 'video_module' ) {
							$link     = get_sub_field( 'video_url' );
							$video_id = explode( "?v=", $link ); // For videos like http://www.youtube.com/watch?v=...
							if ( empty( $video_id[1] ) ) {
								$video_id = explode( "/v/", $link );
							} // For videos like http://www.youtube.com/watch/v/..

							$video_id  = explode( "&", $video_id[1] ); // Deleting any other params
							$video_id  = $video_id[0];
							$video_url = 'https://www.youtube.com/embed/' . $video_id;

							echo '<iframe width="420" height="315" src="' . $video_url . '"></iframe>';

						}
						// Add more conditions for other flexible content layouts as needed

					} // End while loop
				}

			endwhile; endif;
		?>
    </div>
</section>

<?php get_footer() ?>


<style>
    .faq-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .faq-module {
        font-family: Arial, sans-serif;
        display: flex;
        flex-direction: column;
    }

    .qa-container {
        flex-basis: 100%;
        margin-bottom: 20px;
        background-color: white;
        border: none;
        padding: 10px;
        text-align: left;
        cursor: pointer;
    }

    .accordion {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 18px;
        transition: 0.4s;
        display: flex;
        align-items: center;
        background-color: white;
    }


    .qa-container:not(.active):hover .accordion {
        color: #b1b1ca;
    }

    .active,
    .qa-container:hover .accordion {
        background-color: #ccc;
    }

    .panel {
        padding: 0 18px;
        display: none;
        background-color: transparent;
        overflow: hidden;
        border: 2px solid #ccc;
        border-top: none;
    }

    .panel.active {
        background-color: white;
    }

    .panel p {
        font-size: 15px;
    }

    .plus,
    .minus {
        font-size: 20px;
        width: 20px;
        height: 20px;
        text-align: center;
        line-height: 20px;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .minus {
        display: none;
        background-image: url('http://employee-onboarding.test/wp-content/uploads/2023/08/minus.png');
        background-color: transparent;
    }

    .plus {
        background-image: url('http://employee-onboarding.test/wp-content/uploads/2023/08/plus.png');
        display: block;
    }

    .accordion.active .plus {
        display: none;
    }

    .accordion.active .minus {
        display: inline-flex;
    }

    .qa-container .panel {
        margin-top: 5px;
    }

    /* Apply the background color #c8c9d9 on hover for plus and minus icons */
    .qa-container:hover .plus,
    .qa-container:hover .minus {
        background-color: #c8c9d9;
    }

    /* Responsive styles */

    /* Mobile */
    @media (max-width: 767px) {
        .panel {
            border-left: 2px solid #ccc;
            padding-top: 10px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const accordions = document.querySelectorAll('.accordion');

        accordions.forEach(accordion => {
            const plusImageUrl = 'http://employee-onboarding.test/wp-content/uploads/2023/08/plus.png';
            const minusImageUrl = 'http://employee-onboarding.test/wp-content/uploads/2023/08/minus.png';

            // Function to toggle the accordion state and plus/minus icons
            function toggleAccordion() {
                const panel = this.nextElementSibling;
                const isExpanded = this.getAttribute('data-expanded') === 'true';

                if (isExpanded) {
                    this.setAttribute('data-expanded', 'false');
                    panel.style.display = 'none';
                    this.querySelector('.plus').style.display = 'inline-block';
                    this.querySelector('.minus').style.display = 'none';
                } else {
                    this.setAttribute('data-expanded', 'true');
                    panel.style.display = 'block';
                    this.querySelector('.plus').style.display = 'none';
                    this.querySelector('.minus').style.display = 'inline-block';
                }
            }

            accordion.addEventListener('click', toggleAccordion);
        });
    });
</script>
