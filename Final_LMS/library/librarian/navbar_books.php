<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <!-- Responsive Navbar Button for Mobile -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <!-- Navbar links -->
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li><a href="dashboard.php"><i class="icon-home icon-large"></i>&nbsp;Home</a></li>
                    <li><a href="users.php"><i class="icon-user icon-large"></i>&nbsp;Users</a></li>
                    
                    <?php include('dropdown.php'); ?>
                    
                    <li class="active"><a href="books.php"><i class="icon-book icon-large"></i>&nbsp;Books</a></li>
                    <li><a href="member.php"><i class="icon-group icon-large"></i>&nbsp;Members</a></li>
                    <li><a href="#myModal" data-toggle="modal"><i class="icon-search icon-large"></i>&nbsp;Search</a></li>
                    <!-- Uncomment if needed -->
                    <!-- <li><a href="section.php"><i class="icon-th-large icon-large"></i>&nbsp;Sections</a></li> -->
                </ul>

                <!-- Logout button -->
                <div class="pull-right">
                    <div class="admin">
                        <a href="#logout" data-toggle="modal"><i class="icon-signout icon-large"></i>&nbsp;Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('search_form.php'); ?>
