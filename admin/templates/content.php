<div class="col-md-9 content">
    <?php
    
    if (isset($_GET['tab'])) {
        $tab = trim(addslashes(htmlspecialchars($_GET['tab'])));
    }
    else {
        $tab = '';
    }

    // Nếu có tham số tab
    if ($tab != '') {
        if ($tab == 'profile') {
            require_once "templates/profile.php";
        }
        if ($tab == 'posts') {
            require_once "templates/posts.php";
        }
        if ($tab == 'accounts') {
            require_once "templates/accounts.php";
        }
        if ($tab == 'photos') {
            require_once "templates/photos.php";
        }
        if ($tab == 'categories') {
            require_once "templates/categories.php";
        }
        if ($tab == 'setting') {
            require_once "templates/setting.php";
        }
    }
    else {
        require_once "templates/dashboard.php";
    }
    ?>
</div>