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
    </style>
</head>
<body>

<div class="container">

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
            <nav aria-label="breadcrumb" style="text-align: right; direction: rtl;">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">خانه</a></li>
                    @if(isset($parent))
                        <li class="breadcrumb-item active" aria-current="page">{{$parent->name}}</li>
                    @endif
                </ol>
            </nav>
            <div class="col-md-12">
                @foreach($directories as $directory)
                    <div class="col-md-2 text-center">
                        <a href="{{route('show.folder',$directory->slug)}}" class="folder-area">
                            <div>
                                <i class="fa fa-folder"></i>
                            </div>
                            <span>{{$directory->name}}</span>
                        </a>
                    </div>
                @endforeach
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
</div>
</body>
</html>
