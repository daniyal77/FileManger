<!-- create folder -->
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


<!-- rename folder -->
<div class="modal fade" id="renameFolder" tabindex="-1" aria-labelledby="renameFolder" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تغییر نام پوشه</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('rename.folder') }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="rename_folder_id" name="id" class="form-control">

                    <div class="form-group">
                        <label for="rename_folder_name">نام فولدر</label>
                        <input type="text" id="rename_folder_name" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="rename_folder_slug">نامک</label>
                        <input type="text" id="rename_folder_slug" name="slug" class="form-control">
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
