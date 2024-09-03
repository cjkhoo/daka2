<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
 

    <style>
        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem;
            transition: margin 0.25s ease-out;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
        }

        #sidebar-wrapper .list-group {
            width: 15rem;
        }

        #page-content-wrapper {
            min-width: 100vw;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }

        @media (min-width: 768px) {
            #sidebar-wrapper {
                margin-left: 0;
            }

            #page-content-wrapper {
                min-width: 0;
                width: 100%;
            }

            #wrapper.toggled #sidebar-wrapper {
                margin-left: -15rem;
            }
        }

        .sidebar-link {
            display: flex;
            align-items: center;
        }

        .sidebar-link i {
            margin-right: 0.5rem;
        }

        .company{
            padding: 5px;
            text-decoration: none;
            color: #000;
            font-weight: 600;
        }
        .content{
            padding: 20px;
        }
        .copyright {
            text-align: center;
            background-color: aqua;
            color: black;
            border: 1px solid black;
            margin: 1px auto;
            padding: 1px;
            max-width: 200px;
 
        }
        .footer {
            background-color: #000;
            padding:20px;
   
       
        }
        .form-group{
            padding-top:15px;
        }
            .checkin {
        background-color: #98F5F9 !important;
    }
    .checkout {
        background-color: #D8F4CE !important;
    }
    </style>
   
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">管理面板</div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action bg-light sidebar-link">
                    <i class="fas fa-users"></i>人員管理
                </a>
                <a href="{{ route('admin.locations.index')}}" class="list-group-item list-group-item-action bg-light sidebar-link">
                    <i class="fas fa-map-marker-alt"></i> 工作地點管理
                </a>
                <a href="{{ route('admin.report.checkin')}}" class="list-group-item list-group-item-action bg-light sidebar-link">
                    <i class="fas fa-chart-bar"></i> 報告
                </a>
                <a href="#" class="list-group-item list-group-item-action bg-light sidebar-link">
                    <i class="fas fa-sign-out-alt"></i> 
                    <form action="{{ route('admin.logout') }}" method="POST">
                     @csrf
                        <button type="submit" class="dropdown-item" style="padding:0">登出</button>
                    </form>
                </a>

            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar    navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <!-- <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button> -->

                    <a href="{{route('admin.users.index')}}" class="company"> <h2>{{config('view.company.name')}}</h2></a>
                    <button class="navbar-toggler d-block d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>


                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle show" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> 管理面板
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end show"  aria-expanded="true" aria-labelledby="navbarDropdown">
                                    <li>
                                         <a href="{{ route('admin.users.index') }}" class="dropdown-item">
                                            <i class="fas fa-users"></i>人員管理
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item">
                                            <i class="fas fa-map-marker-alt"></i> 工作地點管理
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item">
                                            <i class="fas fa-chart-bar"></i> 報告
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                         <form action="{{ route('admin.logout') }}" method="POST">
                                             @csrf
                                        <a href="#" class="dropdown-item" >
                                            <i class="fas fa-sign-out-alt"></i> 
                                           
                                                <button type="submit" class="dropdown-item" style="display: contents;padding:0">登出</button>
                                           
                                        </a>
                                         </form>
                                    </li>
                                   
                            
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="content">
               
                @yield('content')
                    

            </div>
<!-- Footer -->

        </div>

    </div>
    <footer class="footer ">
    <div class="container text-center">
       <p class="text-center copyright">CopyRight By @Yihren</p>
    </div>
</footer>
<script src=
"https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <script src=
"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js">
    </script>

    @yield('scripts')
</body>
</html>