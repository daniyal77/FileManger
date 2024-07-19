<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>File Manager Template | PrepBootstrap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link rel="stylesheet" type="text/css" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}"/>

    <script type="text/javascript" src="{{asset('assets/js/jquery-1.10.2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <style>
        .folder-area {
            color: unset !important;
            cursor: pointer;
        }

        a:focus, a:hover {
            text-decoration: unset !important;
        }

        .folder-area:hover {
            text-decoration: unset !important;
        }

        .folder-area div {
            height: 150px;
            background: #eee;
        }

        .folder-area div i {
            font-size: 100px;
            display: flex;
            height: -webkit-fill-available;
            flex-direction: row;
            justify-content: space-evenly;
            align-items: center;
        }

        .folder-area span {
            display: block;
            background: #ccc;
        }

        .nav-bar-action {
            text-align: right;
            margin-bottom: 10px;
        }

        .nav-bar-action a {
            background: #333;
            color: white;
            border-radius: 5px;
            padding: 10px;
            margin: 5px;
        }


        #contextMenu {
            display: none;
            position: absolute;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            width: 140px;

        }

        #contextMenu ul {
            list-style: none;
            padding: 10px;
            margin: 0;
        }

        #contextMenu li {
            padding: 8px 12px;
            cursor: pointer;
        }

        #contextMenu li:hover {
            background-color: #f0f0f0;
        }

        a {
            color: #3d3d3d !important;
            text-decoration: unset !important;
        }


    </style>
</head>
<body>

<div class="container" style="direction: rtl;">

    <div class="page-header">
        <h1>File Manager <small>A responsive file manager template</small></h1>
    </div>
    <div class="nav-bar-action">
        <a href="">بارگذاری</a>
        <span class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">ساخت پوشه</span>
        <a href="">فیلتر</a>
        <a href="">سطل زباله</a>
    </div>
    <div class="row">
        <div class="container">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">خانه</a></li>
                    @if(isset($parent))
                        @foreach($breadcrumbs  as $breadcrumb)
                            @if($loop->last)
                                <li class="breadcrumb-item active" aria-current="page">{{$breadcrumb->name}}</li>
                            @else
                                <li class="breadcrumb-item"><a
                                        href="{{route('show.folder',$breadcrumb->slug)}}">{{$breadcrumb->name}}</a></li>
                            @endif
                        @endforeach
                    @endif
                </ol>
            </nav>
            <div class="col-md-10">
                @if(!request()->routeIs('main.folder'))
                    <div class="col-md-2 text-center">
                        <a href="h" class="folder-area">
                            <div>
                                <i class="fa fa-level-up"></i>
                            </div>
                            <span>بازگشت</span>
                        </a>
                    </div>
                @endif
                @foreach($directories as $directory)
                    <div class="col-md-2 text-center">
                        <a href="{{route('show.folder',$directory->slug)}}" class="folder-area"
                           data-name="{{ $directory->name }}">
                            <div>
                                <i class="fa fa-folder"></i>
                            </div>
                            <span>{{$directory->name}}</span>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="col-md-2">
                <img src="a.jpg" style="width: 100%;" alt="">
                <div class="">
                    <p>نام</p>
                    <span>aaaa</span>
                </div>
                <div class="">
                    <p>URL کامل</p>
                    <span>aaaa</span>
                </div>
                <div class="">
                    <p>بارگذاری شده در</p>
                    <span>aaaa</span>
                </div>
                <div class="">
                    <p>اصلاح شده در</p>
                    <span>aaaa</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ایجاد پوشه</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('create.folder') }}" method="post">
                    @csrf

                    <input type="hidden" name="parent_id" value="{{$parent_id}}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">نام فولدر</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="slug">نامک</label>
                            <input type="text" id="slug" name="slug" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                        <button class="btn btn-primary">ثبت</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="contextMenu">
        <ul>
            <li><a href="">تغییر نام</a></li>
            <li><a href="">حذف</a></li>
            <li><a href="">دانلود</a></li>
            <li><a href="">پیش نمایش</a></li>
            <li><a href="">کپی لینک</a></li>
        </ul>
    </div>

</div>

<script>
    const folders = document.querySelectorAll('.folder-area');
    const contextMenu = document.getElementById('contextMenu');

    folders.forEach(folder => {
        folder.addEventListener('contextmenu', function (event) {
            event.preventDefault();
            const folderName = folder.getAttribute('data-name');
            console.log('کلیک راست بر روی:', folderName);
            contextMenu.style.display = 'block';
            contextMenu.style.top = `${event.pageY}px`;
            contextMenu.style.left = `${event.pageX}px`;
        });
    });

    document.addEventListener('click', function () {
        contextMenu.style.display = 'none';
    });
</script>
</body>
</html>
