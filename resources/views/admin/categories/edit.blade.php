<div class="modal fade modal_edit" id="exampleModaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">edit product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="" method="PATCH" id="editsubmitt" enctype="multipart/form-data">
            @csrf
			@method('patch')
            <div class="modal-body">
                <input type="hidden" name="id" id="id">
                
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Title</label>
                    <input type="text" class="form-control" name="title" required id="titlee">
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">image:</label>
                    <input type="file" class="form-control" id="image"    name="image"> 
					<img src='' id="old_img" border="0" style=" width: 80px; height: 80px;" class="img-responsive img-rounded" align="center" />
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
</div>
