@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Product Details Card -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="main-image-container">
                                    <img src="{{ asset($product->main_image) }}" alt="Product Main Image"
                                        class="img-fluid main-image">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h1>{{ $product->name }}</h1>
                                <p>{{ $product->description }}</p>
                                <p>Price: ${{ $product->price }}</p>
                                <p>Category: {{ $product->category->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Images/Videos Card -->
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Product Images/Videos</h5>
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#staticBackdrop">Add Image/Video</button>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach ($product->productImages as $image)
                            <!-- Display Product Images/Videos -->
                            <div class="mb-3">
                                @if ($image->type == 'image')
                                    <img src="{{ asset($image->path) }}" alt="Product Image"
                                        class="img-fluid product-image">
                                @elseif ($image->type == 'video')
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <video controls class="embed-responsive-item">
                                            <source src="{{ asset($image->path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                @endif
                                <!-- Delete Button -->
                                <form action="{{ route('product-images.destroy', ['product_image' => $image->id]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger mt-2">Delete</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Add Image/Video</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('product-images.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="form-group">
                                        <input type="file" name="path" class="form-control"
                                            placeholder="Product Image/Video" required>
                                    </div>
                                    <div class="form-group">
                                        <select name="type" class="form-control">
                                            <option value="image">Image</option>
                                            <option value="video">Video</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
