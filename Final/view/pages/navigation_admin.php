<!-- Navigation for admin pages -->
<nav id="admin-nav">
    <div class="header">
        <a href="index.php" class="">
            Daily Quotes
        </a>
        <div class="links">
            <form action="admin.php" id="admin-control">
                <input type="hidden" name="action" id="admin-input" value="">
                <!-- Display navigation based on current page -->
                <?php if (!$approval) { ?>
                    <div onclick="navControl('approvals')">Approvals</div>
                <?php } else { ?>
                    <div onclick="navControl('home')">Home</div>
                <?php } ?>

                <div onclick="navControl('logout')">Logout</div>
            </form>
        </div>
    </div>
</nav>