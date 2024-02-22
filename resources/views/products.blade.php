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
                                <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Product name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <textarea name="description" class="form-control" placeholder="Product description" required style="height: 150px;""></textarea>
                                    </div>

                                    <div class="form-group">
                                        <input type="file" name="main_image" class="form-control"
                                            placeholder="Product main_image" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="price" class="form-control"
                                            placeholder="Product price" required>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="category_id" id="">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
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
                                <form id="editForm" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')@csrf
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Product name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <textarea name="description" class="form-control" placeholder="Product description" style="height: 150px;" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <input type="file" name="main_image" class="form-control"
                                            placeholder="Product main_image" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="price" class="form-control"
                                            placeholder="Product price" required>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="category_id">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
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
                            <th> Name</th>
                            <th> Description</th>
                            <th> Main Image</th>
                            <th> Price</th>
                            <th> Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr data-product-id="{{ $product->id }}"
                                data-product-category-id="{{ $product->category->id }}">
                                <td class=" product-name">{{ $product->name }}</td>
                                <td class=" product-description">{{ $product->description }}</td>
                                <td class=" product-main_image">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $product->main_image }}" alt="Product Image"
                                            class="img-fluid product-img" style="max-width: 100px;">
                                    </div>
                                </td>
                                <td class=" product-price">{{ $product->price }}</td>
                                <td class=" product-category_id">{{ $product->category->name }}</td>
                                <td class="">
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-warning btn-edit" data-toggle="modal"
                                            data-target="#editModal">
                                            Edit
                                        </button>
                                        <form action="{{ route('product.destroy', ['product' => $product->id]) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class=" ml-3 btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                    <div class="">
                                        <a href="{{ route('product.show', ['product' => $product->id]) }}"> <button
                                                type="button" class="btn btn-primary" 
                                                >View Details </button></a>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $products->links() }}
            </div>
        </div>
    </div>
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="" alt="Product Image" id="largeImage" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.product-img').on('click', function() {
                var imageUrl = $(this).attr('src');
                $('#largeImage').attr('src', imageUrl);
                $('#imageModal').modal('show');
            });
            $('.btn-edit').on('click', function() {
                var ProductName = $(this).closest("tr").find(".product-name").text();
                $('#editModal input[name="name"]').val(ProductName);
                var ProductDescription = $(this).closest("tr").find(".product-description").text();
                $('#editModal textarea[name="description"]').val(ProductDescription);

                var ProductPrice = $(this).closest("tr").find(".product-price").text();
                $('#editModal input[name="price"]').val(ProductPrice);
                var ProductCategory_id = $(this).closest('tr').data('product-category-id');;
                $('#editModal input[name="category_id"]').val(ProductCategory_id);
                var ProductId = $(this).closest('tr').data('product-id');
                $('#editForm').attr('action', '/product/' + ProductId);
                $('#editModal').modal('show');
            });
            $('#saveChangesBtn').on('click', function() {
                $('#editForm').submit();
            });
        });
    </script>
@endsection
