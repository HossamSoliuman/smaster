@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-11">
                <h1>Products</h1>
                <button type="button" class=" mb-3 btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                    Create a new Product
                </button>

                <!-- Creating Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">New Product</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('products.store') }}" method="post">
                                    @csrf
									<div class="form-group">
										<input type="text" name="name" class="form-control" placeholder="Product name" required>
									</div>
									<div class="form-group">
										<input type="text" name="description" class="form-control" placeholder="Product description" required>
									</div>
									<div class="form-group">
										<input type="text" name="main_image" class="form-control" placeholder="Product main_image" required>
									</div>
									<div class="form-group">
										<input type="text" name="price" class="form-control" placeholder="Product price" required>
									</div>
									<div class="form-group">
										<input type="text" name="category_id" class="form-control" placeholder="Product category_id" required>
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
                <!-- Edit Product Modal -->
                <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" method="post">
                                    @csrf
                                    @method('PUT')@csrf
									<div class="form-group">
										<input type="text" name="name" class="form-control" placeholder="Product name" required>
									</div>
									<div class="form-group">
										<input type="text" name="description" class="form-control" placeholder="Product description" required>
									</div>
									<div class="form-group">
										<input type="text" name="main_image" class="form-control" placeholder="Product main_image" required>
									</div>
									<div class="form-group">
										<input type="text" name="price" class="form-control" placeholder="Product price" required>
									</div>
									<div class="form-group">
										<input type="text" name="category_id" class="form-control" placeholder="Product category_id" required>
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
							<th> Name</th>
							<th> Description</th>
							<th> Main_image</th>
							<th> Price</th>
							<th> Category_id</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($products as $product)
                            <tr data-product-id="{{ $product->id }}">
							<td class=" product-name">{{ $product->name }}</td>
							<td class=" product-description">{{ $product->description }}</td>
							<td class=" product-main_image">{{ $product->main_image }}</td>
							<td class=" product-price">{{ $product->price }}</td>
							<td class=" product-category_id">{{ $product->category_id }}</td>
                                <td class="d-flex">
                                    <button type="button" class="btn btn-warning btn-edit" data-toggle="modal"
                                        data-target="#editModal">
                                        Edit
                                    </button>
                                    <form action="{{ route('products.destroy', ['product' => $product->id]) }}"
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
				var ProductName = $(this).closest("tr").find(".product-name").text();
				$('#editModal input[name="name"]').val(ProductName);
				var ProductDescription = $(this).closest("tr").find(".product-description").text();
				$('#editModal input[name="description"]').val(ProductDescription);
				var ProductMain_image = $(this).closest("tr").find(".product-main_image").text();
				$('#editModal input[name="main_image"]').val(ProductMain_image);
				var ProductPrice = $(this).closest("tr").find(".product-price").text();
				$('#editModal input[name="price"]').val(ProductPrice);
				var ProductCategory_id = $(this).closest("tr").find(".product-category_id").text();
				$('#editModal input[name="category_id"]').val(ProductCategory_id);
                var ProductId = $(this).closest('tr').data('product-id');
                $('#editForm').attr('action', '/products/' + ProductId);
                $('#editModal').modal('show');
            });
            $('#saveChangesBtn').on('click', function() {
                $('#editForm').submit();
            });
        });
    </script>
@endsection
