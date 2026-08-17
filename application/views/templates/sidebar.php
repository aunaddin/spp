<aside class="main-sidebar sidebar-dark sidebar-custom elevation-4">

    <a href="<?= site_url('dashboard') ?>" class="brand-link d-flex align-items-center">
        <img src="<?= base_url('assets/img/logo.png') ?>"
             alt="Logo"
             class="brand-image-custom">

        <div class="brand-text-wrap ml-2 text-left">
            <div class="brand-title">Pondok Pesantren</div>
            <small class="brand-subtitle">Nurul Ali</small>
        </div>
    </a>

    <div class="sidebar-inner">

        <div class="user-panel-custom">
            <div class="user-text-wrap">
                <a href="<?= site_url('profil') ?>" class="user-name">
                    <?= $this->session->userdata('nama') ?>
                </a>
                <div class="user-role">
                    <?= ucfirst($this->session->userdata('role')) ?>
                </div>
            </div>
        </div>

        <nav class="sidebar-menu-scroll mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <?php
                $current_role = $this->session->userdata('role');
                $current_url  = uri_string();

                foreach ($this->config->item('menu') as $menu):
                    if (in_array($current_role, $menu['roles'])):
                        $is_active = (strpos($current_url, $menu['url']) === 0) ? 'active' : '';
                ?>
                <li class="nav-item">
                    <a href="<?= site_url($menu['url']) ?>" class="nav-link <?= $is_active ?>">
                        <i class="nav-icon <?= $menu['icon'] ?>"></i>
                        <p><?= $menu['label'] ?></p>
                    </a>
                </li>
                <?php
                    endif;
                endforeach;
                ?>
            </ul>
        </nav>

        <div class="sidebar-footer-logout">
            <ul class="nav nav-pills nav-sidebar flex-column">
                <li class="nav-item">
                    <a href="<?= site_url('auth/logout') ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </div>

    </div>
</aside>