@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-11">
                <h1>Navicons</h1>
                <button type="button" class=" mb-3 btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                    Create a new Navicon
                </button>

                <!-- Creating Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">New Navicon</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('nav-icons.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input type="url" name="url" class="form-control" placeholder="Navicon url"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="file" name="image" class="form-control"
                                            placeholder="Navicon image" required>
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
                <!-- Edit Navicon Modal -->
                <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Navicon</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')@csrf
                                    <div class="form-group">
                                        <input type="url" name="url" class="form-control" placeholder="Navicon url"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="file" name="image" class="form-control"
                                            placeholder="Navicon image" required>
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($navicons as $navicon)
                            <tr data-navicon-id="{{ $navicon->id }}">
                                <td class=" navicon-url">{{ $navicon->url }}</td>
                                <td class="banner-image">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $navicon->image }}" alt="Banner Image" class="img-fluid banner-img"
                                            style="max-width: 100px;">
                                    </div>
                                </td>
                                <td class="d-flex">
                                    <button type="button" class="btn btn-warning btn-edit" data-toggle="modal"
                                        data-target="#editModal">
                                        Edit
                                    </button>
                                    <form action="{{ route('nav-icons.destroy', ['nav_icon' => $navicon->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class=" ml-3 btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.btn-edit').on('click', function() {
                var NaviconUrl = $(this).closest("tr").find(".navicon-url").text();
                $('#editModal input[name="url"]').val(NaviconUrl);
                var NaviconImage = $(this).closest("tr").find(".navicon-image").text();
                $('#editModal input[name="image"]').val(NaviconImage);
                var NaviconId = $(this).closest('tr').data('navicon-id')
                $('#editForm').attr('action', '/nav-icons/' + NaviconId);
                $('#editModal').modal('show');
            });
            $('#saveChangesBtn').on('click', function() {
                $('#editForm').submit();
            });
        });
    </script>
@endsection
