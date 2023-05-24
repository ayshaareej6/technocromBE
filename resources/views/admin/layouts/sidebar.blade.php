
            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title" key="t-menu">Menu</li>

                            <li>
                                <a href="{{ route('admin.dashboard')}}" class="waves-effect">
                                    <i class="bx bx-home-circle"></i><span class="badge rounded-pill bg-info float-end"></span>
                                    <span key="t-dashboards">Dashboard</span>
                                </a>
                                
                            </li>
                            <li>
                                <a href="#" class="waves-effect">
                                    <i class="bx bx-bell"></i>
                                    <span class="badge bg-danger rounded-pill float-end"></span>
                                    <span key="t-dashboards">Notifications</span>
                                    <span class="badge bg-danger rounded-pill float-end">{{-- auth()->user()->unreadNotifications->count() --}}</span>
                                </a>
                                <ul class="sub-menu mm-collapse" aria-expanded="false" >
                                    <li><a href="">All Notifications</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-building"></i>
                                    <span key="t-tasks">service</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{route('admin.view.service')}}" key="t-task-list">All Service</a></li>
                                    <li><a href="{{route('admin.add.service')}}" key="t-kanban-board">Add New</a></li>
                                </ul>
                            
                            </li>
                            
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-palette"></i>
                                    <span key="t-tasks">Color</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{route('admin.view.color')}}" key="t-task-list">All Color</a></li>
                                    <li><a href="{{route('admin.add.color')}}" key="t-kanban-board">Add New Color</a></li>
                                </ul>
                            
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-tone"></i>
                                    <span key="t-tasks">Brands</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{route('admin.view.brand')}}" key="t-task-list">All Brands</a></li>
                                    <li><a href="{{route('admin.add.brand')}}" key="t-kanban-board">Add New Brand</a></li>
                                </ul>
                            
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-tone"></i>
                                    <span key="t-tasks">Branding Kit</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{route('admin.view.brandingkit')}}" key="t-task-list">All Branding Kit</a></li>
                                    <li><a href="{{route('admin.add.brandingkit')}}" key="t-kanban-board">Add New Branding Kit</a></li>
                                </ul>
                            
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-tone"></i>
                                    <span key="t-tasks">Branding</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{route('admin.view.branding')}}" key="t-task-list">All Branding</a></li>
                                    <li><a href="{{route('admin.add.branding')}}" key="t-kanban-board">Add New Branding</a></li>
                                </ul>
                            
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-brush"></i>
                                    <span key="t-tasks">Theme</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{route('admin.view.theme')}}" key="t-task-list">All Theme</a></li>
                                    <li><a href="{{route('admin.add.theme')}}" key="t-kanban-board">Add New Theme</a></li>
                                </ul>
                            
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-brush"></i>
                                    <span key="t-tasks">Font</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{route('admin.view.font')}}" key="t-task-list">All Font</a></li>
                                    <li><a href="{{route('admin.add.font')}}" key="t-kanban-board">Add New Font</a></li>
                                </ul>
                            
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-tone"></i>
                                    <span key="t-tasks">Detail</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{route('admin.view.detail')}}" key="t-task-list">All Detail</a></li>
                                    <li><a href="{{route('admin.add.detail')}}" key="t-kanban-board">Add New Detail</a></li>
                                </ul>
                            
                            </li>
                           
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-user"></i>
                                    <span key="t-tasks">Users</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{route('admin.view.user')}}" key="t-task-list">All User</a></li>
                                    <li><a href="{{route('admin.add.user')}}" key="t-kanban-board">Add New User</a></li>
                                </ul>
                            
                            </li>

                            
                            <li>
                                <a href="{{route('admin.web.settings')}}" class="waves-effect">
                                    <i class="bx bx-cog"></i>
                                    <span key="t-order-tasks">Web Setting</span>
                                </a>
                            </li>

                           
                          
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->