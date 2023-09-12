<?php get_header(); ?>

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
			if ( have_posts() ) : while ( have_posts() ) : the_post();
				the_content();
				get_module_data();
				?>
			<?php
			endwhile; endif;
			?>
        </div>
    </section>

<?php get_footer(); ?>