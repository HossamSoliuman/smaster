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

                        <div id="uploadStatus" class="mb-3"></div>
                        <div id="uploadedImages">
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
                                <form id="uploadForm" action="{{ route('product-images.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="form-group">
                                        <input type="file" name="path" class="form-control"
                                            placeholder="Product Image/Video" required>
                                    </div>
                                    <div id="imageUploadProgress" class="progress" style="display: none;">
                                        <div id="uploadProgressBar" class="progress-bar" role="progressbar"
                                            style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="form-group">
                                        <select name="type" class="form-control">
                                            <option value="image">Image</option>
                                            <option value="video">Video</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" id="cancelUpload" class="btn btn-danger">Cancel</button>
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

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#uploadForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var progressBar = $('#uploadProgressBar');
                var statusMsg = $('#uploadStatus');
                var uploadedImagesContainer = $('#uploadedImages');

                $('#imageUploadProgress').show();

                $.ajax({
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total * 100;
                                progressBar.width(percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#imageUploadProgress').hide();
                        $('#uploadForm')[0].reset();
                        $('#staticBackdrop').modal('hide');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        $('#imageUploadProgress').hide();
                        statusMsg.html('<div class="alert alert-danger" role="alert">' + error +
                            '</div>');
                    }
                });
            });

            $('#cancelUpload').click(function() {
                $('#imageUploadProgress').hide();
                $('#uploadForm')[0].reset();
            });
        });
    </script>
@endsection
