<?php get_header(); ?>

    <style>
        main.search-results-container {
            background: #cfcfcf10;
            margin-bottom: 50px;
        }

        .btn {
            background-color: rgba(200, 201, 217, 0.28) !important;
        }

        .btn:hover {
            background-color: #c8c9d9;
            opacity: 0.7;
            border: 1px solid rgba(200, 201, 217, 0.48);
        }

        .search-wrapper {
            margin-left: 95px;
        }
    </style>

    <main class="search-results-container search-wrapper">
		<?php
		$search_term = get_search_query();

		if ( ! empty( trim( $search_term ) ) ) {
			$query_args = array(
				'posts_per_page' => 10
			);

			if ( strcasecmp( $search_term, 'post' ) === 0 || strcasecmp( $search_term, 'posts' ) === 0 ) {
				$query_args['post_type'] = 'post';
			} elseif ( strcasecmp( $search_term, 'page' ) === 0 || strcasecmp( $search_term, 'pages' ) === 0 ) {
				$query_args['post_type'] = 'page';
			} else {
				$post_types              = get_post_types( array( 'public' => true ), 'names' );
				$query_args['s']         = $search_term;
				$query_args['post_type'] = $post_types;

				// Exclude user profile pages from search results
				$exclude_users             = get_users( array( 'fields' => 'ID' ) );
				$user_profile_args         = array(
					'post_type'      => 'page',
					'author__in'     => $exclude_users,
					'posts_per_page' => - 1,
					'fields'         => 'ids'
				);
				$excluded_user_profile_ids = get_posts( $user_profile_args );
				if ( ! empty( $excluded_user_profile_ids ) ) {
					$query_args['post__not_in'] = $excluded_user_profile_ids;
				}
			}

			$search_query = new WP_Query( $query_args );

			$user_query = new WP_User_Query( array(
				'search'         => '*' . esc_attr( $search_term ) . '*',
				'search_columns' => array(
					'user_login',
					'user_nicename',
					'user_email',
					'user_url',
					'display_name',
				),
			) );
			$users      = $user_query->get_results();

			if ( $search_query->have_posts() || ! empty( $users ) ) :
				?>
                <div class="container mx-auto">
                    <div class="results-for bg-white p-12 sm:w-full md:w-full lg:w-1/2 lg:mx-auto mt-16 shadow rounded-3xl text-center">
                        <h2 class="text-4xl font-light">
                            Results for <strong>"<?php echo esc_html( $search_term ) ?>"</strong>
                        </h2>
                    </div>
                </div>

                <div class="container lg:w-7/12 mx-auto mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 justify-center">
					<?php
					while ( $search_query->have_posts() ) : $search_query->the_post();
						$result_count   = $search_query->post_count;
						$grid_col_class = "";
						if ( $result_count == 1 ) {
							$grid_col_class = "sm:col-span-1 md:col-span-1 lg:col-span-3";
						} elseif ( $result_count >= 2 ) {
							$grid_col_class = "sm:col-span-1 md:col-span-1 lg:col-span-1";
						}
						?>
                        <div class="card bg-white shadow my-3 p-6 shadow hover:shadow-xl hover:transition rounded-3xl <?php echo $grid_col_class; ?>">
                            <div class="card-body">
                                <div class="card-title">
                                    <h2 class="text-2xl mb-6 font-bold">
										<?php the_title(); ?>
                                    </h2>
                                </div>
                                <div class="card-text mt-3 overflow-hidden"
                                     style="min-height: 100px; max-height: 100px">
                                    <p>
										<?php the_excerpt(); ?>
                                    </p>
                                </div>
                                <div class="card-footer rounded-xl mt-4 mb-0">
                                    <a href="<?php echo the_permalink(); ?>"
                                       class="btn rounded-full py-3 px-12 btn text-slate-800">
										<?php echo esc_html__( 'Details!', 'employee-onboarding' ); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
					<?php endwhile; ?>

					<?php
					// Display users
					foreach ( $users as $user ) {
						?>
                        <div class="card bg-white shadow my-3 p-6 shadow hover:shadow-xl hover:transition rounded-3xl <?php echo $grid_col_class; ?>">
                            <div class="card-body">
                                <div class="card-title">
                                    <h2 class="text-2xl mb-6 font-bold">
										<?php echo $user->display_name; ?>
                                    </h2>
									<?php
									if ( get_the_author_meta( 'description', $user->ID ) ) {
										?>
                                        <p class="card-text mb-4">
											<?php echo get_the_author_meta( 'description', $user->ID ); ?>
                                        </p>
										<?php
									}
									?>
                                </div>
                                <div class="card-footer rounded-xl mt-4 mb-0">
                                    <a href="<?php echo get_author_posts_url( $user->ID ); ?>"
                                       class="btn rounded-full py-3 px-12 btn text-slate-800">
										<?php echo esc_html__( 'Profile!', 'employee-onboarding' ); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
						<?php
					}
					?>
                </div>

				<?php
				the_posts_pagination( array( 'total' => $search_query->max_num_pages ) );
			else :
				?>
                <div class="container fallback-msg mx-auto px-4 md:px-0">
                    <article class="mt-12 w-full flex flex-col items-center">
                        <div class="container mb-12">
                            <div class="card bg-white shadow p-6 md:p-12 w-full lg:w-3/4 mx-auto rounded-2xl shadow"
                                 style="margin: 0 auto">
                                <div class="card-body font-sans">
                                    <img src="<?php echo get_template_directory_uri() . '/images/OIP-removebg-preview.png' ?>"
                                         alt="Fallback Icon" class="w-28 h-28 animate-bounce mx-auto">
                                    <div class="card-title mt-6 mb-4 md:my-6 text-center">
                                        <h2 class="text-2xl md:text-3xl lg:text-4xl">
											<?php printf(
												esc_html__( 'We could not find any results for "%s"', 'employee-onboarding' ),
												esc_html( $search_term )
											); ?>
                                        </h2>
                                    </div>
                                    <div class="card-text text-center">
                                        <p class="text-lg md:text-xl text-center">
											<?php echo esc_html__( 'You might also be interested in our other content. Please try again or browse our categories.', 'employee-onboarding' ); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="container sm:w-full md:w-full lg:w-7/12 mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-8 gap-x-4">
					<?php
					$fallback_query_args = array(
						'post_type'      => array( 'post', 'page' ),
						'posts_per_page' => - 1,
						'post__not_in'   => $excluded_user_profile_ids
					);

					$fallback_query = new WP_Query( $fallback_query_args );

					while ( $fallback_query->have_posts() ) : $fallback_query->the_post();
						?>
                        <div class="card bg-white shadow hover:shadow-xl hover:transition p-6 rounded-3xl">
                            <div class="card-body">
                                <div class="card-title mb-4">
                                    <h2 class="text-xl font-bold">
										<?php the_title(); ?>
                                    </h2>
                                </div>
                                <div class="card-text" style="min-height: 100px">
                                    <p>
										<?php the_excerpt(); ?>
                                    </p>
                                </div>
                                <div class="card-footer rounded-xl mt-4 mb-0">
                                    <a href="<?php echo the_permalink(); ?>"
                                       class="btn rounded-full py-3 px-12 btn text-slate-800">
										<?php echo esc_html__( 'Details!', 'employee-onboarding' ); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
					<?php endwhile; ?>
                </div>
				<?php
				the_posts_pagination( array( 'total' => $fallback_query->max_num_pages ) );
				wp_reset_postdata();
			endif;
		} else {
			echo esc_html__( 'Please enter a search term', 'employee-onboarding' );
		}
		?>
    </main>

<?php get_footer(); ?>