<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <a class="navbar-brand" href="/demoshop/frontend/index.php">DemoShop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        ariacontrols="navbarSupportedContent" aria-expanded="false" arialabel="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/demoshop/frontend/pages/admin.php">Admin</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/demoshop/frontend/pages/about.php">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/demoshop/frontend/pages/contact.php">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/demoshop/frontend/pages/viewCart.php">Cart</a>
            </li>
        </ul>
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        ?>
        <ul class="navbar-nav px-3 ml-auto">
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item text-nowrap">
                    <a class="nav-link">Welcome <?= htmlspecialchars($_SESSION['username']); ?></a>
                </li>
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="/demoshop/frontend/pages/logout.php">Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="/demoshop/frontend/pages/login.php">Login</a>
                </li>
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="/demoshop/frontend/pages/register.php">Register</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>