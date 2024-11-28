<div class="navbar navbar-inverse set-radius-zero" >
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" >

                 <img src="assets/img/lib.jpg" />
             <img src="assets/img/xox.png" style="width: 90px;height: 40px;" />
                </a>

            </div>
<?php if($_SESSION['login'])
{
?> 
            <div class="right-div">
                <a href="logout.php" class="btn btn-danger pull-right">LOG OUT</a>
            </div>
            <?php }?>
        </div>
    </div>
    <!-- LOGO HEADER END-->
<?php if($_SESSION['login'])
{
?>    
<section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="dashboard.php" class="menu-top-active">DASHBOARD</a></li>
                             <li><a href="staff.php">Library Staff</a></li>
                           
                          
                            
                                <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Rating <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="ratingbook.php">Rate Books</a></li>
                                      <li role="presentation"><a role="menuitem" tabindex="-1" href="viewratebook.php">View Rating</a></li>
                                </ul>
                            </li>
                               <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Books <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="listed-books.php">All Books</a></li>
                                      <li role="presentation"><a role="menuitem" tabindex="-1" href="issued-books.php">Issued Books</a></li>
                                       <li role="presentation"><a role="menuitem" tabindex="-1" href="fines-book.php">Overdue Books</a></li>
                                      <li role="presentation"><a role="menuitem" tabindex="-1" href="rentbook.php">Check Out Books</a></li>
                                </ul>
                            </li>  <li><a href="forum.php">Forum</a></li>
                             <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Account <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="my-profile.php">My Profile</a></li>
                                     <li role="presentation"><a role="menuitem" tabindex="-1" href="change-password.php">Change Password</a></li>
                                    
                                </ul>
                                  <li role="presentation"><a role="menuitem" tabindex="-1" href="user_manual.php">FAQ</a></li>
                            </li>

                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <?php } else { ?>
        <section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">                        
                          
      <li><a href="index.php">Home</a></li>
       <li><a href="allbook.php">All Books</a></li>

      <li><a href="userlogin.php">Login</a></li>
                            <li><a href="signup.php">Signup</a></li>
                            <li><a href="adminlogin.php">Admin</a></li>
                            <li><a href="user_manual.php">FAQ</a></li>

                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php } ?>