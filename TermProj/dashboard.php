<?php
	include('session.php');
    include('getGroup.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Study Buddy+ | My Dashboard</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">StudyBuddy+</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b
                        class="caret"></b></a>
                <ul class="dropdown-menu alert-dropdown">
                    <li>
                        <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                    </li>
                    <li>
                        <a href="#">Alert Name <span class="label label-primary">Notice</span></a>
                    </li>
                    <li>
                        <a href="#">Alert Name <span class="label label-success">Answer</span></a>
                    </li>
                    <li>
                        <a href="#">Alert Name <span class="label label-warning">Question</span></a>
                    </li>
                    <li>
                        <a href="#">Alert Name <span class="label label-danger">Exam</span></a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">View All</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['login_user']; ?> <b
                        class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
                </ul>
            </li>
        </ul>
        <?php 
            $data = getGroup($_SESSION["login_user"]);
        ?>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li class="active">
                    <a href="#"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li>
                <li>
                    <a href="javascript:" data-toggle="collapse" data-target="#demo"><i
                            class="fa fa-fw fa-arrows-v"></i> My Groups <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="demo" class="collapse">
                       
                        <?php 
                        foreach($data as $oneGroup) {
                            //echo "<li><form action='grouppage.php' method='post'><input type='submit' name='groupname' value='$oneGroup[0]'/></form></li>"; 
                            echo "<li><form action='grouppage.php' method='post'>
                                <input style='display:none' name='gname' value='$oneGroup[0]'/>
                                <a style='color:white;margin-left:30px;' href='grouppage.php' onclick=\"this.parentNode.submit(); return false;\">$oneGroup[0]</a>
                            </form></li>";
                        }
                        ?>
                        
                    </ul>
                </li>
                <li>
                    <a href="create_group.php"><i class="fa fa-fw fa-edit"></i> Create Group</a>
                </li>
                <li>
                    <a href="calendar.html"><i class="fa fa-fw fa-table"></i>My Calendar</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Dashboard
                        <small>Recent Activity</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-dashboard"></i> My Feed
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-info alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-info-circle"></i>  <strong>Welcome!</strong> This is your main study feed. Here you can find the most recent updates for your different study groups.
                    </div>
                    <?php 
                    $posts_count = 0;
                    foreach($data as $oneGroup) {
                        $_SESSION[$oneGroup['groupName']] = true; //mark in session which group the student belongs to
                        $posts = getPostsByGroup($oneGroup['groupName']); //get all the group names the user belongs to
                        $posts_count += count($posts);
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $posts_count; ?></div>
                                <div>Posts in all your groups!</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo count($data) ?></div>
                                <div>Study Groups!</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i>Latest Posts</h3>
                    </div>
                    <div class="panel-body">
                        <div id="morris-donut-chart">
                        <?php 
                        foreach($data as $oneGroup) {
                            echo "<h4> In " . $oneGroup['groupName'] . "<h4/>";
                            echo "<ul>";
                            $posts = getPostsByGroup($oneGroup['groupName']);
                            if (count($posts) > 3) {
                                for ($i = count($posts)-1; $i > count($posts)-4; $i--) {
                                    echo "<li>" . $posts[$i]['student'] . " said: " . $posts[$i]['comment'] . " at " . $posts[$i]['time'] . "</li>";
                                
                                }
                            } elseif (count($posts) > 0){
                                for ($i = 0; $i < count($posts); $i++) {
                                    echo "<li>" . $posts[$i]['student'] . " said: " . $posts[$i]['comment'] . " at " . $posts[$i]['time'] . "</li>";
                                }
                            } else {
                                echo "<li>Ooops... no updates from the group</li>";
                                break;
                            }
                            echo "</ul>";
                            echo "<div class='text-right'>
                                <form action='grouppage.php' method='post' id='$oneGroup[0]'>
                                    <input style='display:none' name='gname' value='$oneGroup[0]'/>
                                    <a href='grouppage.php' onclick=\"this.parentNode.submit(); return false;\">View Details<i class='fa fa-arrow-circle-right'></i></a>
                                </form>
                            </div>";
                            //echo '<div class="text-right"><a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a></div>';
                        }
                        ?>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i>Group Searcher</h3>
                    </div>
                    <div class="panel-body">
                        <form action="dashboard.php" method="post">
                            <div class="list-group">
                                Search by group name or course number
                                <input style="width:80%" name="gName" type="text" placeholder="enter group name"/>
                                <input style="width:80%" name="cNum" type="text" placeholder="enter course number"/>
                            </div>
                            <div class="text-right">
                                <input name="send" type="submit" value="search"/>
                            </div>
                            <?php 
                                
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
