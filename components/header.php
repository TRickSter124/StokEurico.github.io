<header class="pc-header">
    <div class="header-wrapper">
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <li class="pc-h-item header-mobile-collapse"><a href="#" class="pc-head-link head-link-secondary ms-0" id="sidebar-hide"><i class="ti ti-menu-2"></i></a></li>
                <li class="pc-h-item pc-sidebar-popup"><a href="#" class="pc-head-link head-link-secondary ms-0" id="mobile-collapse"><i class="ti ti-menu-2"></i></a></li>
            </ul>
        </div>
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item header-user-profile"><a class="pc-head-link head-link-primary dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false"><img src="assets/images/admin-profile.jpg" alt="user-image" class="user-avtar"> <span><i class="ti ti-settings"></i></span></a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header">
                            <h4>Hi, <span class="small text-muted"><?=$_SESSION['email']?></span></h4>
                            <hr>
                            <a href="funcs/logout.php" class="dropdown-item">
                                <i class="ti ti-logout"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>