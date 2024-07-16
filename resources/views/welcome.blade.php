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
    </style>
</head>
<body>

<div class="container">

    <div class="page-header">
        <h1>File Manager <small>A responsive file manager template</small></h1>
    </div>

    <div class="row">
        <div class="container">
            <div class="col-md-12">
                @foreach($directories as $directory)
                    <div class="col-md-2 text-center">
                        <a href="{{$directory->slug}}" class="folder-area">
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


</div>

</body>
</html>
