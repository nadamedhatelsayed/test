@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('title')
    {{ __('activities.titles.index') . '-' . env('APP_NAME') }}
@endsection

@section('content')
    @include('layouts.partials.breadcrumb', [
        'name' => __('categories'),
    ])
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <h2 class="">categories</h2>

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                                    data-whatever="@mdo">Create</button>
                                @include('admin.categories.edit')
                                @include('admin.categories.create')

                            </div>
                            <table id="table_id" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>image</th>
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
                ajax: "{{ route('categories.index') }}",
                columns: [{
                        data: 'id',
                    },
                    {
                        data: 'title',
                    },

                    {
                        data: 'image',
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
            let url = "{{ route('categories.store') }}";
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
            var title = $(this).data('title');
            var image = $(this).data('image');

            $('#id').val(id);
            $('#titlee').val(title);
            $("#exampleModaledit #old_img").attr('src', "{{ asset('') }}/" + image);



        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#editsubmitt').submit(function(e) {
            e.preventDefault();
            var id = $('#id').val();
            let url = "{{ route('cat.update', 'id') }}";
            url = url.replace('id', id)
            $.ajax({
                url: url,
                type: "POST",
                "_token": "{{ csrf_token() }}",
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
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

            let url = "{{ route('categories.destroy', 'id') }}";
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
    </script>
@endsection
