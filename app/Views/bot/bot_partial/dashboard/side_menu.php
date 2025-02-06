<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
                <img src="<?= base_url('../assets/assets/images/logouns.png') ?>" alt="" width="60" height="60">
            </a>
        </div>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100 ">
                <a class="nav-link" href="<?= base_url('bot')?>">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span>
                </a>
            </li>
        </ul>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Akses Chatbot</span>
    </p>

        <ul class="navbar-nav flex-fill w-100 mb-1">
            <li class="nav-item dropdown">
                <a data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link" href="#bot">
                    <i class="fe fe-message-circle fe-16"></i>
                    <span class="ml-3 item-text">Chatbot D3TI</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="bot">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('bot/register_chatbot')?>"><span
                                class="ml-1 item-text">Reigstrasi Chatbot</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="<?=base_url('bot/akses_chatbot')?>"><span class="ml-1 item-text">
                                Akses Chatbot</span></a>
                    </li>

                </ul>
            </li>
        </ul>
        <?php if(has_permission('laboran')) : ?>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Kembali ke SIMLAB</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100 ">
                <a class="nav-link" href="<?= base_url('simlab') ?>">
                    <i class="fe fe-arrow-left fe-16"></i>
                    <span class="ml-3 item-text">SIMLAB</span>
                </a>
            </li>
        </ul>
        <?php endif; ?>
    </nav>
</aside>