@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('title')
    {{ __('activities.titles.index') . '-' . env('APP_NAME') }}
@endsection

@section('content')
    @include('layouts.partials.breadcrumb', [
        'name' => __('products'),
    ])
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <h2 class="">products</h2>

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                                    data-whatever="@mdo">Create</button>
                                @include('admin.products.edit')
                                @include('admin.products.create')
                                @include('admin.products.images')

                            </div>
                            <table id="table_id" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Decription</th>
                                        <th>control</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/admin/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/admin/js/data-table.js') }}"></script>
    <script type="text/javascript">
        $(function() {

            var table = $('#table_id').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('products.index') }}",
                columns: [{
                        data: 'id',
                    },
                    {
                        data: 'title',
                    },
                    {
                        data: 'description',
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });
        $('body').on('submit', '#submit', function(e) {
            e.preventDefault();
            let url = "{{ route('products.store') }}";
            $.ajax({
                url: url,
                method: "post",
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response == 'SUCCESS') {
                        $('#table_id').DataTable().ajax.reload()
                        $('.modal_create').modal('hide');


                    } else {

                    }
                },
            });
        });
        $('body').on('click', '.edit-btn', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var price = $(this).data('price');
            var title = $(this).data('title');
            var description = $(this).data('description');
            var category_id = $(this).data('category_id');

            $('#id').val(id);
            $('#pricee').val(price);
            $('#titlee').val(title);
            $('#descriptionn').val(description);

            $('#exampleModaledit #category_id').val(category_id);


        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('body').on('submit', '#editsubmit', function(e) {

            e.preventDefault();
            var id = $('#id').val();

            let url = "{{ route('products.update', 'id') }}";
            url = url.replace('id', id)
            var price = $('#pricee').val();
            var title = $('#titlee').val();
            var description = $('#descriptionn').val();
            var category_id = $('#category_id').val();
            $.ajax({
                url: url,
                method: "PATCH",

                data: {
                    'id': id,
                    'price': price,
                    'title': title,
                    'description': description,
                    'category_id': category_id,
                },
                dataType: 'json',
                // cache: false,
                // contentType: false,
                // processData: false,
                success: function(response) {
                    console.log(response);
                    if (response.errors) {

                    }
                    if (response == 'SUCCESS') {
                        $('#table_id').DataTable().ajax.reload()
                        $('.modal_edit').modal('hide');

                    }
                },
            });
        });
        $('body').on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            let url = "{{ route('products.destroy', 'id') }}";
            url = url.replace('id', id)

            $.ajax({
                url: url,
                method: "DELETE",

                data: {
                    'id': id,
                },
                dataType: 'json',

                success: function(response) {

                    if (response == 'SUCCESS') {
                        $('#table_id').DataTable().ajax.reload()

                    }
                },
            });
        });
        $('body').on('click', '.image-btn', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#exampleModaledit2 #id').val(id);
            let url = "{{ route('products.image.show', 'id') }}";
            url = url.replace('id', id)

            $.ajax({
                url: url,
                method: "get",

                data: {
                    'id': id,
                },
                dataType: 'json',
                success: function(response) {

                    console.log(response)
                    $('#exampleModaledit2 #getimages').empty();
                    $(response.data).each(function(a, value) {
                        var image = "http://" + window.location.host + value.image;
                        console.log(image)
                        $('#exampleModaledit2 #getimages').append('<img src="' + image +
                            '" id="image' + value.id +
                            '" style=" width: 150px; margin-bottom:5px  "><button type="button" id="imagee' + value.id +
                            '"  data-id="' +
                            value.id +
                            '" class="btn btn-danger deleteimage">delete</button> <br>')

                    })
                },
            });
        });
        $('body').on('click', '.deleteimage', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            let url = "{{ route('products.image.delete', 'id') }}";
            url = url.replace('id', id)

            $.ajax({
                url: url,
                method: "post",

                data: {
                    'id': id,
                },
                dataType: 'json',
                success: function(response) {
                   if(response.data == 'success'){
                       $('#image'+id).remove();
                       $('#imagee'+id).remove();
                   }
                }
            });
        });
    </script>
@endsection
