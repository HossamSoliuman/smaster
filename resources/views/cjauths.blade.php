@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-11">
                <h1>CjAuths</h1>
                <button type="button" class=" mb-3 btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                    Create a new CjAuth
                </button>

                <!-- Creating Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">New CjAuth</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('cj-auths.store') }}" method="post">
                                    @csrf
									<div class="form-group">
										<input type="text" name="email" class="form-control" placeholder="CjAuth email" required>
									</div>
									<div class="form-group">
										<input type="text" name="key" class="form-control" placeholder="CjAuth key" required>
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
                <!-- Edit CjAuth Modal -->
                <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit CjAuth</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" method="post">
                                    @csrf
                                    @method('PUT')@csrf
									<div class="form-group">
										<input type="text" name="email" class="form-control" placeholder="email" required>
									</div>
									<div class="form-group">
										<input type="text" name="key" class="form-control" placeholder="key" required>
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
							<th> Email</th>
							<th> Key</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($cjAuths as $cjAuth)
                            <tr data-cjAuth-id="{{ $cjAuth->id }}">
							<td class="cjAuth-email">{{ $cjAuth->email }}</td>
							<td class="cjAuth-key">{{ $cjAuth->key }}</td>
							    <td class="d-flex">
                                    <button type="button" class="btn btn-warning btn-edit" data-toggle="modal"
                                        data-target="#editModal">
                                        Edit
                                    </button>
                                    <form action="{{ route('cj-auths.destroy', ['cj_auth' => $cjAuth->id]) }}"
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

				var CjAuthEmail = $(this).closest("tr").find(".cjAuth-email").text();
				$('#editModal input[name="email"]').val(CjAuthEmail);

				var CjAuthKey = $(this).closest("tr").find(".cjAuth-key").text();
				$('#editModal input[name="key"]').val(CjAuthKey);

				 var CjAuthId = $(this).closest('tr').data('cjAuth-id');
                $('#editForm').attr('action', '/cj-auths/' + CjAuthId);

                $('#editModal').modal('show');
            });
            $('#saveChangesBtn').on('click', function() {
                $('#editForm').submit();
            });
        });
    </script>
@endsection
