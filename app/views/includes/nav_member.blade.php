 <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">
                   @if(Confide::user()->user_type != 'teller') 
                    <li>
                        <a href="{{ URL::to('members/create') }}"><i class="glyphicon glyphicon-user fa-fw"></i> New Member</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('members') }}"><i class="fa fa-users fa-fw"></i> Members</a>
                    </li>

                    @endif

                    @if(Confide::user()->user_type == 'teller')
                    <li>
                        <a href="{{ URL::to('/') }}"><i class="fa fa-users fa-fw"></i> Members</a>
                    </li>
                    @endif
                </ul>
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->