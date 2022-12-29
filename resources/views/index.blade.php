@extends('layouts.main')
@section('main-section')

<style>
    .section1{
        margin-top: 100px;
        background-color: rgb(245, 245, 245);
        border: 4px transparent;
        border-radius: 10px;
        padding: 10px;
    }
</style>

@push('title')
    <title>PdfModify</title>
@endpush
<div class="container fileUploadSection">
    <div class="section1">
        <form action="{{url('/upload')}}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="mb-3 center my-4" style="width: 80%; margin:10px auto;">
                    @if (session()->has('errorMsg'))
                        <p class='danger'>{{session()->get('errorMsg')}}</p>
                    @endif
                <div class="row">
                    <div class="fileInputDiv col-md-6">
                        <label for="formFile" class="form-label"><b>Upload Pdf File -</b> </label>
                        <input class="form-control" type="file" name="pdf" id="formFile" required>
                        <span class="text-danger">
                            @error('file')
                                <h6>{{$message}}</h6>
                            @enderror
                        </span>
                    </div>
                    <div class="positionInputDiv col-md-4">
                        <label for="positionInput" class="form-label"><b>Select Page Number Position</b> </label>
                        <select class="form-select form-control" id="positionInput" name="position" aria-label="Select Page Number Position" required>
                            <option value="B" selected>Bottom</option>
                            <option value="T">Top</option>
                            <option value="TL">Top-Left</option>
                            <option value="TR">Top-Right</option>
                            <option value="BL">Bottom-Left</option>
                            <option value="BR">Bottom-Right</option>
                        </select>
                    </div>
                    <div class="fontSizeInputDiv col-md-2">
                        <label for="fontSizeInput" class="form-label"><b>Font Size</b> </label>
                        <select class="form-select form-control" id="fontSizeInput" name="fontsize" aria-label="Select Page Number Position" required>
                            <option value="11" selected>11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            optio
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-secondary my-3 col-12">Upload</button>
            </div>
        </form>
    </div>
</div>    
@endsection