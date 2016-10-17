<body>


    

    <div id="wrapper">

        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header"  >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php 

    $organization = DB::table('organizations')->where('id', '=', 1)->pluck('name');

    
?> 
                <a class="navbar-brand"  href="{{ URL::to('/')}}" > <?php echo $organization; ?></a>
            </div>
            <!-- /.navbar-header -->

        

            <ul class="nav navbar-top-links navbar-right">

                <!-- /.dropdown -->
               
                <li class="dropdown" style="background-color:white;">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  {{ Confide::user()->username}} <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ URL::to('members/profile' ) }}"><i class="fa fa-user fa-fw"></i>  Profile</a>
                        </li>
                        
                        <li class="divider"></li>
                        <li><a href="{{ URL::to('users/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                        
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            
            </ul>
            <!-- /.navbar-top-links -->

        </nav>
        <!-- /.navbar-static-top -->