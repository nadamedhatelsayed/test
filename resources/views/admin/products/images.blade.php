<div class="modal fade modal_images" id="exampleModaledit2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> upload images  </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{route('upload.images')}}" method="post" id="imagesform" enctype="multipart/form-data">
            @csrf
             <input type="hidden" name="id" id="id">
             <input type="file" class="form-control" name="images[]" accept="image/*" multiple>
             <div id="getimages">
                 
             </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
</div>
