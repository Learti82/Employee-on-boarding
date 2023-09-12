<style>
  .main-container {
    display: flex;
    flex-direction: row;
    width: 280px;
    height: 100%;
  }
  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: 240px;
    background-color: white;
    padding: 10px;
    border-right: 1px solid rgba(200, 201, 217, 0.48);
  }
  .site-container {
    display: flex;
    align-items: center;
  }
  .avatar-container {
    width: 40%;
  }
  .site-text {
    width: 60%;
  }
  .sidebar-toggle {
    position: fixed;
    width: 20px;
    height: 20px;
    bottom: 100px;
    right: -10px;
    padding: 5px;
    color: black;
    cursor: pointer;
    border: 1px solid #b1b1ca;
    border-radius: 15px;
    background: #b1b1ca;
    opacity: 0.47999998927116394;
    z-index: 999;
  }
  .custom-nav {
    flex: 1;
    margin-top: 50px;
  }
  .custom-nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  .custom-nav li {
    display: block;
    margin-bottom: 10px;
  }
  .custom-nav li a {
    display: flex;
    align-items: center;
    padding: 16px 80px;
    gap: 16px;
    font-size: 14px;
    font-style: normal;
    font-weight: 500;
    line-height: 20px;
    text-decoration: none;
    color: #b1b1ca;
    width: 220px;
    padding: 16px;
    box-sizing: border-box;
    border-radius: 15px;
  }
  /* Style the links (<a> elements) inside the <li> elements */
  .custom-nav li a:hover {
    color: black;
    font-size: 16px;
    font-style: normal;
    font-weight: 500;
    opacity: 0.47999998927116394;
    background: #c8c9d9;
    border-radius: 15px;
    box-shadow: 3px 3px 3px  #E0E0E0;
  }
  .menu-icon {
    width: 20px;
    height: 20px;
    margin-right: 10px;
  }
  .menu-item-content {
    display: flex;
    align-items: center;
    justify-content: flex-start;
  }
  .custom-nav li.current-menu-item a {
    background-color: #b1b1ca;
    border-radius: 15px;
    color: black;
    opacity: 0.47999998927116394;
    font-size: 16px;
    font-style: normal;
    font-weight: 500;
    box-shadow: 3px 3px 3px  #E0E0E0;
  }
.sidebar.sidebar-hidden {
  position: fixed;
  top: 0;
  left: 0;
  bottom: 0;
  width: 100%;
  max-width: 100px;
  height: 100%;
}
.sidebar.sidebar-hidden .site-container {
  display: flex;
  align-items: center;
  width: 80px;
}
.sidebar.sidebar-hidden .avatar-container {
  width:100%;
  max-width: 60px;
  height: 60px;
}
.sidebar.sidebar-hidden .site-text {
  display: none;
}
.sidebar.sidebar-hidden .custom-nav li a {
  padding: 8px;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 60px;  
}
.sidebar.sidebar-hidden .menu-icon {
  margin-right: 5px;
}
.sidebar.sidebar-hidden .menu-text {
  display: none;
}
.sidebar.sidebar-hidden .custom-nav li a:hover {
  background-color: #c8c9d9;
  border-radius: 10px;
  opacity: 0.8;
  transform: scale(1.05);
  transition: all 0.2s ease-in-out;
  max-width: 60px;
  box-shadow: 3px 3px 3px  #E0E0E0;
}
.sidebar.sidebar-hidden .custom-nav li a:hover .menu-text {
  display: block;
  position: absolute;
  top: 50%;
  left: 100%;
  transform: translateY(-50%);
  padding-right: 8px;
  padding-left: 8px;
  padding-top: 2px;
  padding-bottom: 2px;
  white-space: nowrap;
  background-color: #c8c9d9;
  border-radius: 10px;
  color: black;
  font-size: 10px;
  font-style: normal;
  font-weight: 500;
  opacity: 0.47999998927116394;
  box-shadow: 3px 3px 3px  #E0E0E0;
}

/* Styles for smaller screens */
@media screen and (max-width: 1300px) {
  .main-container {
    display: flex;
    flex-direction: row;
    width: 100px;
    height: 100%;
  }
  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: 100%;
    max-width: 100px;
    height: 100%;
    background-color: white;
    padding: 10px;
  }
  .sidebar-toggle {
    display: none;
  }
  .site-container {
    display: flex;
    align-items: center;
    width: 80px;
  }
  .avatar-container {
    width: 100%;
    max-width: 60px;
    height: 60px;
  }
  .site-text {
    display: none;
  }
  .custom-nav li a {
    padding: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 60px;
  }
  .menu-icon {
    margin-right: 5px;
  }
  .menu-text {
    display: none;
  }
    /* The hover effect for smaller screens */
  .custom-nav li a:hover {
    background-color: #c8c9d9;
    border-radius: 10px;
    opacity: 0.8;
    transform: scale(1.05);
    transition: all 0.2s ease-in-out;
    max-width: 60px;
    box-shadow: 3px 3px 3px  #E0E0E0;
  }
  .custom-nav li a:hover .menu-text {
    display: block;
    position: absolute;
    top: 50%;
    left: 100%;
    transform: translateY(-50%);
    padding-right: 8px;
    padding-left: 8px;
    padding-top: 2px;
    padding-bottom: 2px;
    white-space: nowrap;
    background-color: #c8c9d9;
    border-radius: 10px;
    color: black;
    font-size: 10px;
    font-style: normal;
    font-weight: 500;
    opacity: 0.47999998927116394;
    box-shadow: 3px 3px 3px  #E0E0E0;
  }
}
</style>

<div class="main-container">
  <aside class="sidebar sidebar-open">
    <div class="site-container flex items-center" style="border-bottom: 1px solid rgba(67, 44, 44, 0.24); padding-bottom: 10px;">
      <div class="avatar-container">
        <?php
        $site_logo = get_field('site_logo', 'option');
        if (empty($site_logo)) {
          $defaultLogoUrl = get_template_directory_uri() . '/images/starlabs.png';
          $site_logo = $defaultLogoUrl;
        }
        ?>
        <img src="<?php echo esc_url($site_logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
      </div>
      <div class="site-text text-white" style="margin: 5px;">
        <h1 class="text-inter text-base font-medium leading-11 tracking-tighter uppercase text-opacity-40" style="margin: 0; padding-bottom:1px; color: #242220;">
          <?php
          $site_name = get_field('site_name', 'option');
          if (empty($site_name)) {
            $site_name = get_bloginfo('name');
          }
          echo esc_html($site_name);
          ?>
        </h1>
        <h4 class="text-inter text-sm font-medium leading-5 uppercase" style="margin: 0; white-space: nowrap; color: #b1b1ca;">
          <?php
          $site_description = get_field('site_description', 'option');
          if (empty($site_description)) {
            $site_description = get_bloginfo('description');
          }
          ?>
          <p class="site-description"><?php echo esc_html($site_description); ?></p>
        </h4>
      </div>
    </div>

    <!-- Menu -->
    <nav class="custom-nav" style="color: rgb(255, 255, 255);">
      <ul id="custom-menu" class="p-4 text-sm">
        <?php
        $args = array(
          'theme_location' => 'primary-menu',
          'container' => 'ul',
          'menu_class' => 'p-4 text-sm',
        );
        $menu_items = wp_get_nav_menu_items('primary-menu');
        if (is_array($menu_items) && count($menu_items) > 0) {
          foreach ($menu_items as $menu_item) {
            $menu_item_classes = implode(' ', $menu_item->classes);
            ?>
            <li class="<?php echo esc_attr($menu_item_classes); ?><?php if (in_array('current-menu-item', $menu_item->classes)) echo ' current-menu-item'; ?>">
              <a href="<?php echo esc_url($menu_item->url); ?>" class="menu-item-content">
                <?php
                $icon_image = get_field('menu_icon', $menu_item->ID);
                if (!empty($icon_image)) : ?>
                  <img src="<?php echo esc_url($icon_image['url']); ?>" class="menu-icon" alt="Menu Icon">
                <?php endif; ?>
                <span class="menu-text"><?php echo esc_html($menu_item->title); ?></span>
              </a>
              <?php if (!empty($menu_item->title)) : ?>
                <span class="menu-text"><?php echo esc_html($menu_item->title); ?></span>
              <?php endif; ?>
            </li>
            <?php
          }
        } else {
          echo '<ul class="p-4 text-sm text-black">';
          echo '<li>Menu not found or not assigned.</li>';
          echo '</ul>';
        }
        ?>
      </ul>
    </nav>
    <?php if (!wp_is_mobile()) : ?>
    <button id="sidebar-toggle" class="sidebar-toggle">
      <img src="<?php echo get_template_directory_uri(); ?>/images/left.png" alt="Left Icon" id="toggle-icon">
    </button>
    <?php endif; ?>
  </aside>
</div>

<!-- JavaScript/jQuery to highlight the current menu item and toggle the sidebar-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
		<?php if (!wp_is_mobile()) : ?>
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.querySelector('.sidebar');
        const toggleIcon = document.getElementById('toggle-icon');
        const userElement = document.querySelector('.user');

        if (sidebar.classList.contains('sidebar-open')) {
            userElement.classList.remove('pull');
            userElement.classList.add('push');
        } else {
            userElement.classList.remove('pull');
        }

        const contentArea = document.querySelector('.content-area');

        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('sidebar-hidden');
            document.body.classList.toggle('sidebar-open');

            // Icon image change on click
            if (sidebar.classList.contains('sidebar-hidden')) {
                toggleIcon.src = '<?php echo get_template_directory_uri(); ?>/images/right.png';
                toggleIcon.alt = 'Closed Icon';
            } else {
                toggleIcon.src = '<?php echo get_template_directory_uri(); ?>/images/left.png';
                toggleIcon.alt = 'Open Icon';
            }

            if (document.body.classList.contains('sidebar-open')) {
                userElement.classList.remove('push');
            } else {
                userElement.classList.add('push');
            }


            if (document.body.classList.contains('sidebar-open')) {
                contentArea.classList.remove('push-content');
            } else  {
                contentArea.classList.add('push-content');

            }

        });

		<?php endif; ?>

        // Shows the current page
        var currentUrl = window.location.href;

        var menuItems = document.querySelectorAll('#custom-menu li a');
        menuItems.forEach(function(menuItem) {
            var menuItemUrl = menuItem.getAttribute('href');

            if (currentUrl.includes(menuItemUrl)) {
                menuItem.closest('li').classList.add('current-menu-item');
            }
        });
    });


</script>