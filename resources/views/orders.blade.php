@extends('layouts.admin')
@section('content')
    <div class="container ">
        <div class="row ">
            <div class="col-md-11">
                <h1>Orders</h1>
                <button type="button" class=" mb-3 btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                    Create a new Order
                </button>

                <!-- Creating Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">New Order</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('orders.store') }}" method="post">
                                    @csrf
									<div class="form-group">
										<input type="text" name="shipping_address" class="form-control" placeholder="Order shipping_address" required>
									</div>
									<div class="form-group">
										<input type="text" name="user_id" class="form-control" placeholder="Order user_id" required>
									</div>
									<div class="form-group">
										<input type="text" name="status" class="form-control" placeholder="Order status" required>
									</div>
									<div class="form-group">
										<input type="text" name="session_id" class="form-control" placeholder="Order session_id" required>
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
                <!-- Edit Order Modal -->
                <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Order</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" method="post">
                                    @csrf
                                    @method('PUT')@csrf
									<div class="form-group">
										<input type="text" name="shipping_address" class="form-control" placeholder="Order shipping_address" required>
									</div>
									<div class="form-group">
										<input type="text" name="user_id" class="form-control" placeholder="Order user_id" required>
									</div>
									<div class="form-group">
										<input type="text" name="status" class="form-control" placeholder="Order status" required>
									</div>
									<div class="form-group">
										<input type="text" name="session_id" class="form-control" placeholder="Order session_id" required>
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
							<th> Shipping_address</th>
							<th> User_id</th>
							<th> Status</th>
							<th> Session_id</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($orders as $order)
                            <tr data-order-id="{{ $order->id }}">
							<td class=" order-shipping_address">{{ $order->shipping_address }}</td>
							<td class=" order-user_id">{{ $order->user_id }}</td>
							<td class=" order-status">{{ $order->status }}</td>
							<td class=" order-session_id">{{ $order->session_id }}</td>
                                <td class="d-flex">
                                    <button type="button" class="btn btn-warning btn-edit" data-toggle="modal"
                                        data-target="#editModal">
                                        Edit
                                    </button>
                                    <form action="{{ route('orders.destroy', ['order' => $order->id]) }}"
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
				var OrderShipping_address = $(this).closest("tr").find(".order-shipping_address").text();
				$('#editModal input[name="shipping_address"]').val(OrderShipping_address);
				var OrderUser_id = $(this).closest("tr").find(".order-user_id").text();
				$('#editModal input[name="user_id"]').val(OrderUser_id);
				var OrderStatus = $(this).closest("tr").find(".order-status").text();
				$('#editModal input[name="status"]').val(OrderStatus);
				var OrderSession_id = $(this).closest("tr").find(".order-session_id").text();
				$('#editModal input[name="session_id"]').val(OrderSession_id);
                var OrderId = $(this).closest('tr').data('order-id');
                $('#editForm').attr('action', '/orders/' + OrderId);
                $('#editModal').modal('show');
            });
            $('#saveChangesBtn').on('click', function() {
                $('#editForm').submit();
            });
        });
    </script>
@endsection
