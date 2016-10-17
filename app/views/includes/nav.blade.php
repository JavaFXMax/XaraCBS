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
         
               
                
               

                 

                <li  >
                    <a  href="{{ URL::to('dashboard')}}">
                        <i class="fa fa-home fa-fw"></i>  {{{ Lang::get('messages.nav.dashboard') }}}
                    </a>
                    
                </li>

@if(Confide::user()->user_type != 'teller')
                <li  >
                    <a  href="{{ URL::to('members')}}">
                        <i class="fa fa-users fa-fw"></i>  {{{ Lang::get('messages.nav.members') }}} 
                    </a>
                    
                </li>


                 

                 <li  >
                    <a  href="{{ URL::to('accounts')}}">
                        <i class="fa fa-file fa-fw"></i>  {{{ Lang::get('messages.nav.accounting') }}} 
                    </a>
                    
                </li>

                <li  >
                    <a  href="{{ URL::to('portal')}}">
                        <i class="fa fa-random fa-fw"></i>  CSS 
                    </a>
                    
                </li>

                <li  >
                    <a  href="{{ URL::to('reports')}}">
                        <i class="fa fa-file fa-fw"></i>  {{{ Lang::get('messages.nav.reports') }}}
                    </a>
                    
                </li>

                

               <li class="dropdown" >
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-cogs fa-fw"></i>  {{{ Lang::get('messages.nav.administration') }}} <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ URL::to('organizations') }}"><i class="fa fa-home fa-fw"></i>  Organization</a>
                        </li>
                        <li class="divider"></li>

                         <li><a href="{{ URL::to('loanproducts') }}"><i class="fa fa-barcode fa-fw"></i>  Loan Management</a>
                        </li>
                        <li class="divider"></li>

                         <li><a href="{{ URL::to('savingproducts') }}"><i class="fa fa-user fa-fw"></i>  Savings Management</a>
                        </li>
                        <li class="divider"></li>

                         <li><a href="{{ URL::to('shares/show/1') }}"><i class="fa fa-user fa-fw"></i>  Share Management</a>
                        </li>
                        <li class="divider"></li>

                          <li><a href="{{ URL::to('charges') }}"><i class="fa fa-user fa-fw"></i>  Charge Management</a>
                        </li>

                        <li class="divider"></li>

                          <li><a href="{{ URL::to('monthlyremittances/show/1') }}"><i class="fa fa-user fa-fw"></i>  Monthly Remittance Management</a>
                        </li>
                        
                        <li class="divider"></li>
                        <li><a href="{{ URL::to('system') }}"><i class="fa fa-sign-out fa-fw"></i> System</a>
                        </li>
                        
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->




                
                

                @endif

                



                


                <!-- /.dropdown -->
               
                <li class="dropdown" style="background-color:white;">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  {{ Confide::user()->username}} <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ URL::to('users/profile/'.Confide::user()->id ) }}"><i class="fa fa-user fa-fw"></i>  Profile</a>
                        </li>

                       
                        <li class="divider"></li>
                        <li><a href="{{ URL::to('users/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>


                       

                        
                        
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->


                <li>
                    

                        
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        @if(Session::get('lang') == 'ks')
                            Kiswahili
                        @endif 

                         @if(Session::get('lang') == 'en')
                            English
                        @endif 


                         <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>

                            {{link_to_route('language.select', 'English', array('en'))}}

                        </li>

                       
                        <li class="divider"></li>

                         <li>

                            {{link_to_route('language.select', 'Kiswahili', array('ks'))}}

                        </li>

                       
                        <li class="divider"></li>
                        


                       

                        
                        
                    </ul>

                    

                   

                </li>


                
            
            </ul>
            <!-- /.navbar-top-links -->

        </nav>
        <!-- /.navbar-static-top -->