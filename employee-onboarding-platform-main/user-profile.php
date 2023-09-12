<?php
/*
	Template Name: user-profile
*/
get_header();

// Retrieve cover photo URL from the user's metadata
$user_id         = get_current_user_id();
$cover_photo_url = get_user_meta( $user_id, 'cover_photo', true );

// If there's a cover photo URL, set it as the background; else use bg-slate-200
$cover_style = $cover_photo_url ? "style='background-image: url($cover_photo_url);'" : "";

$profile_photo_url = get_user_meta( $user_id, 'profile_image', true );
$current_user      = wp_get_current_user();
$username          = $current_user->user_login;
$bio               = $current_user->user_description;
$location = get_user_meta( $user_id, 'location', true );


?>

<main class="user-profile">
    <div class="cover-photo bg-slate-200" <?php echo $cover_style; ?>>
        <div class="edit" title="Edit Image">
            <input type="file" id="coverPhotoInput" style="display: none;">
            <img src="<?php echo get_template_directory_uri() . '/images/pen.png'; ?>" alt="Edit">
            <div class="edit-actions-dropdown" style="display: none;">
                <a href="#" class="see-cover-image">See cover image</a>
                <a href="#" class="upload-cover-image">Upload an image</a>
                <a href="#" class="delete-cover-image">Delete photo</a>
            </div>
        </div>
    </div>


    <div class="profile-img" style="background-image: url('<?php
	echo $profile_photo_url ? esc_url( $profile_photo_url ) : esc_url( get_avatar_url( $user_id ) ); ?>')">
        <div class="profile-actions-dropdown" style="display: none;">
            <a href="#" class="see-profile-image">See profile image</a>
            <a href="#" class="upload-profile-image">Upload an image</a>
            <a href="#" class="delete-profile-image">Delete photo</a>
            <input type="file" id="profileImageInput" style="display: none;">
        </div>
    </div>

    <!--    Information about the user    -->
    <div class="edit-profile">
        <div class="profile-info">
            <h3 class="fullname"><?php echo $current_user->display_name; ?></h3>
            <h4 class="username">
				<?php echo $username; ?>
            </h4>
            <p class="description">
				<?php echo $bio; ?>
            </p>

            <?php
            if ($location) {
                ?>
                <div class="location">
                    <img src="<?php echo get_template_directory_uri() . '/images/location.png' ?>" alt="Location">
                    <span>
                        <?php echo $location; ?>
                    </span>
                </div>
                <?php
            }

            if ($current_user->user_email) {
                ?>
                <div class="email">
                    <img src="<?php echo get_template_directory_uri() . '/images/mail.png' ?>" alt="Location">
                    <span>
                        <a href="mailto:<?php echo $current_user->user_email ?>">
                            <?php echo $current_user->user_email ?>
                        </a>
                    </span>
                </div>
                <?php
            }

            if ($current_user->user_url) {
                ?>
                <div class="website">
                    <img src="<?php echo get_template_directory_uri() . '/images/world-wide-web.png' ?>" alt="Location">
                    <span>
                        <a href="<?php echo $current_user->user_url; ?>" target="_blank">
                            <?php echo $current_user->display_name; ?>
                        </a>
                    </span>
                </div>
                <?php
            }

            ?>

            <div class="turn-off">
                <button class="sign-off-btn">
                        Sign out
                </button>
            </div>
        </div>

        <div class="update">
            <h2>Update Profile</h2>

            <form action="" method="post" id="profileForm">
		        <?php wp_nonce_field('updateProfile'); ?>

                <!-- Personal Information -->
                <h3>Personal Information</h3>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="firstName">
                </div>

                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName">
                </div>

                <div class="form-group">
                    <label for="fullName">Display Full Name Publicly As</label>
                    <input type="text" id="fullName" name="fullName">
                </div>

                <!-- Contact Information -->
                <h3>Contact Information</h3>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">
                </div>

                <div class="form-group">
                    <label for="website">Website</label>
                    <input type="text" id="website" name="website">
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location">
                </div>

                <!-- Security -->
                <h3>Security</h3>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                </div>

                <!-- About You -->
                <h3>About You</h3>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="bio" id="description" cols="30" rows="10"></textarea>
                </div>

                <div class="buttons">
                    <button type="submit" name="updateProfile" class="save-changes-btn">
                        Save Changes
                    </button>


                    <button class="sign-off-btn" id="removeOnDesktop" type="button">
                        Sign out
                    </button>
                </div>

            </form>

            <?php

            ?>
        </div>
    </div>

    <div id="coverModal" class="cover-modal-hidden">
        <span class="modal-close">&times;</span>
        <img class="modal-content" id="coverImg">
    </div>


    <div id="profileImageModal" class="cover-modal-hidden" style="align-items: center">
        <span class="modal-close">&times;</span>
        <img class="modal-content" id="profileModalImg">
    </div>

</main>

<script>
    class UserProfile {
        constructor() {
            // Elements Initialization
            this.initializeElements();
            this.bindEvents();
        }

        initializeElements() {
            this.elements = {
                coverPhoto: document.querySelector('.cover-photo'),
                edit_cover_photo: document.querySelector('.edit'),
                coverPhotoInput: document.getElementById('coverPhotoInput'),
                modal: document.getElementById('coverModal'),
                modalImg: document.getElementById('coverImg'),
                modalClose: document.querySelectorAll('.modal-close'),
                modalContent: document.querySelector('.modal-content'),
                uploadProfileLink: document.querySelector('.upload-profile-image'),
                profileImageInput: document.getElementById('profileImageInput'),
                profileActionsDropdown: document.querySelector('.profile-actions-dropdown'),
                profileModal: document.getElementById('profileImageModal'),
                profileModalImg: document.getElementById('profileModalImg'),
                seeProfileImageLink: document.querySelector('.see-profile-image'),
                profileImgContainer: document.querySelector('.profile-img'),
                deleteProfileLink: document.querySelector('.delete-profile-image'),
                editDropdown: document.querySelector('.edit-actions-dropdown'),
                uploadCoverLink: document.querySelector('.upload-cover-image'),
                seeCoverImageLink: document.querySelector('.see-cover-image'),
                deleteCoverLink: document.querySelector('.delete-cover-image'),
                logOut: document.querySelector('.sign-off-btn')
            };
        }

        bindEvents() {
            this.elements.coverPhoto.addEventListener('mouseover', () => this.showElement(this.elements.edit_cover_photo));
            this.elements.coverPhoto.addEventListener('mouseout', () => this.hideElement(this.elements.edit_cover_photo));
            this.elements.edit_cover_photo.addEventListener('click', (event) => this.toggleElementDisplay(this.elements.editDropdown, event));
            this.elements.coverPhotoInput.addEventListener('change', this.uploadImage.bind(this, 'cover'));
            this.elements.coverPhoto.addEventListener('click', this.showCoverModal.bind(this));
            this.elements.modalClose.forEach(button => {
                button.addEventListener('click', () => {
                    console.log('Close button clicked');
                    this.hideModal();
                });
            });
            this.elements.modal.addEventListener('click', this.hideModal.bind(this));
            this.elements.modalContent.addEventListener('click', (event) => event.stopPropagation());
            this.elements.profileImgContainer.addEventListener('click', () => this.toggleElementDisplay(this.elements.profileActionsDropdown));
            this.elements.uploadProfileLink.addEventListener('click', (event) => this.triggerInputClick(this.elements.profileImageInput, event));
            this.elements.profileImageInput.addEventListener('change', this.uploadImage.bind(this, 'profile'));
            this.elements.seeProfileImageLink.addEventListener('click', this.showProfileModal.bind(this));
            this.elements.profileModal.addEventListener('click', this.hideProfileModal.bind(this));
            this.elements.profileModalImg.addEventListener('click', (event) => event.stopPropagation());
            document.addEventListener('click', this.hideUnfocusedDropdowns.bind(this));
            this.elements.deleteProfileLink.addEventListener('click', this.deleteProfileImage.bind(this));
            this.elements.seeCoverImageLink.addEventListener('click', this.showCoverModal.bind(this));
            this.elements.deleteCoverLink.addEventListener('click', this.deleteCoverImage.bind(this));
            this.elements.uploadCoverLink.addEventListener('click', (event) => {
                event.preventDefault(); // prevent the default action
                this.elements.coverPhotoInput.click(); // trigger the file input
            });
            this.elements.logOut.addEventListener('click', this.logOutUsers.bind(this));
            document.querySelectorAll('.sign-off-btn').forEach(button => button.addEventListener('click', this.logOutUsers.bind(this)));
        }

        showElement(element) {
            element.style.opacity = '1';
        }

        hideElement(element) {
            element.style.opacity = '0';
        }

        toggleElementDisplay(element, event = null) {
            element.style.display = element.style.display === 'none' ? 'block' : 'none';
            if (event) event.stopPropagation();
        }

        uploadImage(type, event) {
            const file = event.target.files[0];
            if (file) {
                const formData = new FormData();
                formData.append('action', type === 'cover' ? 'save_user_cover_photo' : 'save_user_profile_image');
                formData.append(type === 'cover' ? 'cover_photo' : 'profile_image', file);

                fetch(frontendajax.ajaxurl, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const targetElement = type === 'cover' ? this.elements.coverPhoto : this.elements.profileImgContainer;
                            targetElement.style.backgroundImage = `url(${data.data})`;
                        } else {
                            console.error(data.data);
                        }

                        setTimeout(() => window.location.reload(), 700);
                    });
            }
        }

        showCoverModal(event) {
            if (event.target !== this.elements.edit_cover_photo) {
                this.elements.modal.style.display = "flex";
                this.elements.modalImg.src = this.elements.coverPhoto.style.backgroundImage.slice(5, -2);
            }
        }

        hideModal() {
            let coverModals = document.querySelectorAll('.cover-modal-hidden');
            coverModals.forEach(modal => {
                modal.style.display = 'none';
            });

        }
        hideProfileModal(event) {
            console.log('hideProfileModal function triggered');
            if (event.target === this.elements.profileModal) {
                this.elements.profileModal.style.display = "none";
            }
        }



        triggerInputClick(inputElement, event) {
            inputElement.click();
            event.preventDefault();
        }

        showProfileModal(event) {
            this.elements.profileModal.style.display = "flex";
            let currentBackground = this.elements.profileImgContainer.style.backgroundImage;
            this.elements.profileModalImg.src = currentBackground.slice(5, -2);
            event.preventDefault();
        }

        hideProfileModal(event) {
            if (event.target === this.elements.profileModal) {
                this.elements.profileModal.style.display = "none";
            }
        }

        hideUnfocusedDropdowns(event) {
            if (!this.elements.profileImgContainer.contains(event.target)) {
                this.elements.profileActionsDropdown.style.display = 'none';
            }
            if (!this.elements.edit_cover_photo.contains(event.target) && !this.elements.editDropdown.contains(event.target)) {
                this.elements.editDropdown.style.display = 'none';
            }
        }

        deleteProfileImage(event) {
            this.deleteImage('profile', event);
        }

        deleteCoverImage(event) {
            this.deleteImage('cover', event);
        }

        deleteImage(type, event) {
            event.preventDefault();
            const confirmMessage = type === 'cover' ? "Are you sure you want to delete the cover photo?" : "Are you sure you want to delete the profile image?";

            if (confirm(confirmMessage)) {
                const formData = new FormData();
                formData.append('action', type === 'cover' ? 'delete_user_cover_photo' : 'delete_user_profile_image');

                fetch(frontendajax.ajaxurl, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const targetElement = type === 'cover' ? this.elements.coverPhoto : this.elements.profileImgContainer;
                            targetElement.style.backgroundImage = '';
                            if (type === 'profile') {
                                setTimeout(() => window.location.reload(true), 700);
                            }
                        } else {
                            console.error(data.data);
                        }
                    });
            }
        }

        logOutUsers() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '<?php echo admin_url("admin-ajax.php"); ?>?action=my_logout_action', true);
            xhr.send();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Redirect the user to the desired page after successful logout.
                        window.location.href = "<?php echo home_url(); ?>";
                    }
                }
            };
        }


    }

    document.addEventListener('DOMContentLoaded', () => new UserProfile());


</script>

<?php get_footer() ?>
