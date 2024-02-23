@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-11">
                <h1>Banners</h1>
                <button type="button" class=" mb-3 btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                    Create a new Banner
                </button>

                <!-- Creating Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">New Banner</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('banners.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input type="url" name="url" class="form-control" placeholder="Banner url"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="file" accept="image" name="image" class="form-control"
                                            placeholder="Banner image" required>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="place" id="">
                                            <option name="home" id="">Home Screen</option>
                                            <option name="category" id="">Category Screen</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Banner Modal -->
                <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Banner</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <input type="text" name="url" class="form-control" placeholder="Banner url"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="place" id="">
                                            <select name="home" id="">Home Screen</select>
                                            <select name="category" id="">Category Screen</select>
                                        </select>
                                    </div>
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th> Url</th>
                            <th> Image</th>
                            <th> Place</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banners as $banner)
                            <tr data-banner-id="{{ $banner->id }}">
                                <td class="banner-url">{{ $banner->url }}</td>
                                <td class="banner-image">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $banner->image }}" alt="Banner Image" class="img-fluid banner-img"
                                            style="max-width: 100px;">
                                    </div>
                                </td>
                                <td class="banner-place">{{ $banner->place }}</td>
                                <td class="d-flex">
                                    <button type="button" class="btn btn-warning btn-edit" data-toggle="modal"
                                        data-target="#editModal">
                                        Edit
                                    </button>
                                    <form action="{{ route('banners.destroy', ['banner' => $banner->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ml-3 btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Add a modal for displaying larger image -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="" alt="Banner Image" id="largeImage" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.banner-img').on('click', function() {
                var imageUrl = $(this).attr('src');
                $('#largeImage').attr('src', imageUrl);
                $('#imageModal').modal('show');
            });
            $('.btn-edit').on('click', function() {
                var BannerUrl = $(this).closest("tr").find(".banner-url").text();
                $('#editModal input[name="url"]').val(BannerUrl);
                var BannerPlace = $(this).closest("tr").find(".banner-place").text();
                $('#editModal input[name="place"]').val(BannerPlace);
                var BannerId = $(this).closest('tr').data('banner-id');
                $('#editForm').attr('action', '/banners/' + BannerId);
                $('#editModal').modal('show');
            });

            $('#saveChangesBtn').on('click', function() {
                $('#editForm').submit();
            });
        });
    </script>
@endsection
