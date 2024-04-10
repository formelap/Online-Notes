<?php
// Pobierz nazwę aktualnej strony
$current_page = basename($_SERVER['PHP_SELF']);

function setActive($page_name, $current_page) {
    return $page_name === $current_page ? 'active' : '';
}
?>

<!-- Navigation Bar -->
<nav role="navigation" class="navbar navbar-custo.m sticky-top navbar-expand-sm bg-primary navbar-dark ">
    <div class="container-fluid">
        <!-- <div class="navbar-header"> -->
            <a class="navbar-brand">Notatki Online</a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" >
                <span class="navbar-toggler-icon"></span>

            </button>
        
        <div class="navbar-collapse collapse" id="navbarCollapse">
            <ul class="nav navbar-nav">
                <?php
                    if (isset($_SESSION['user_id']))
                    {
                        echo '<li class="nav-item"><a class="nav-link ' . setActive('mainpageloggedin.php', $current_page) . '" href="mainpageloggedin.php">Notatki</a></li>
                            <li class="nav-item"><a class="nav-link ' . setActive('profile.php', $current_page) . '" href="profile.php">Profil</a></li>';
                    }
                    else 
                    {
                        echo '<li class="nav-item"><a class="nav-link ' . setActive('index.php', $current_page) . '" href="index.php">Strona główna</a></li>';
                    }
                ?>
                
                <li class="nav-item"><a class="nav-link <?php echo setActive('about-us.php', $current_page); ?>" href="about-us.php">O nas</a></li>
                <li class="nav-item"><a class="nav-link <?php echo setActive('contact-us.php', $current_page); ?>" href="contact-us.php">Kontakt</a></li>
            </ul>
            
            <ul class="nav navbar-nav ms-auto">
                <?php
                    if (isset($_SESSION['user_id']))
                    {
                        echo '<li class="nav-item"><a class="nav-link" href="#"><b>'.$_SESSION['username'].'</b></a></li>
                            <li class="nav-item"><a class="nav-link" href="index.php?logout=1">Wyloguj</a></li>';
                    }
                    else 
                    {
                        echo '<li class="nav-item"><a class="nav-link" href="#loginModal" data-bs-toggle="modal">Zaloguj</a></li>';
                    }
                ?>

            </ul>
        </div>
    </div>
</nav>