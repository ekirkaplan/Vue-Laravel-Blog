@extends('Backend.Layout.master')
@section('title', $data->id > 0 ? 'Blog Yazısını Güncelle' : 'Blog Yazısı Ekle')
@section('cssBefore')

@endsection
@section('cssAfter')
    <style>
        .blogImage {
            width: 100%;
            display: block;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">{{ $data->id > 0 ? 'Blog Yazısını Güncelle' : 'Blog Yazısı Ekle' }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Anasayfa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('panel.blog-manage.list.index') }}">Blog Yazı Listesi</a></li>
                        <li class="breadcrumb-item active">{{ $data->id > 0 ? 'Blog Yazısını Güncelle' : 'Blog Yazısı Ekle' }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <form style="display: flex;width: 95%; margin: 0 auto" action="">
            @csrf
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-12">
                                <label for="name">Yazı Başlığı</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12 col-lg-6">
                                <label for="statuss">Yazı Yayın Durumu</label>
                                <select name="status" class="form-control" id="statuss">
                                    <option {{ $data->status == 1 ? 'selected' : '' }} value="1">Yayında</option>
                                    <option {{ $data->status == 0 && $data->id > 0 ? 'selected' : '' }} value="0">Pasif</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="streamDate">Yazı Yayın Tarihi</label>
                                <input type="date" class="form-control" id="streamDate" name="streamDate" value="{{ $data->streamDate }}">
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-12">
                                <label for="contents">Blog Yazısı</label>
                                <textarea name="summernote" id="contents">{!! $data->content !!}</textarea>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row form-group">
                                    <div class="col-12">
                                        <div class="imageContainer">
                                            <img src="{{ asset('backend/assets/images/authentication-bg.jpg') }}" class="blogImage" alt="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-12">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Blog Yazısı Kapak Resmi</label>
                                        </div>
                                    </div>
                                </div>

                                <h3 class="card-title">Blog Kategorileri (Birden Çok Seçilebilir)</h3>
                                @foreach(\App\Models\Category::all() as $category)
                                    @if ($data->id > 0)
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="custom-control custom-switch mb-2" dir="ltr">
                                                    <input type="checkbox" class="custom-control-input categorySwitch"
                                                           name="category[{{ $category->id }}]"
                                                           {{ \App\Models\BlogCategory::where('blog_id', $data->id)->where('category_id', $category->id)->count() > 0 ? 'checked' : ''}}  value="{{ $category->id }}"
                                                           id="categoryId{{ $category->id }}">
                                                    <label class="custom-control-label"
                                                           for="categoryId{{ $category->id }}">{{ $category->name }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="custom-control custom-switch mb-2" dir="ltr">
                                                    <input type="checkbox" class="custom-control-input categorySwitch"
                                                           name="category[{{ $category->id }}]" value="{{ $category->id }}"
                                                           id="categoryId{{ $category->id }}">
                                                    <label class="custom-control-label"
                                                           for="categoryId{{ $category->id }}">{{ $category->name }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button class="btn btn-success w-100" id="sendButton">{{ $data->id > 0 ? 'Güncelle' : 'Kaydet' }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('jsBefore')

@endsection
@section('jsAfter')
    <script src="{{ asset('backend/assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/tinymce/langs/tr_TR.js') }}"></script>
    <script>
        $(document).ready(function () {
            tinymce.init({
                selector: "#contents",
                height: 450,
                language: 'tr_TR',
                plugins: ["advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking", "save table contextmenu directionality emoticons template paste textcolor"],
                toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
                style_formats: [{title: "Bold text", inline: "b"}, {
                    title: "Red text",
                    inline: "span",
                    styles: {color: "#ff0000"}
                }, {title: "Red header", block: "h1", styles: {color: "#ff0000"}}, {
                    title: "Example 1",
                    inline: "span",
                    classes: "example1"
                }, {title: "Example 2", inline: "span", classes: "example2"}, {title: "Table styles"}, {
                    title: "Table row 1",
                    selector: "tr",
                    classes: "tablerow1"
                }],
                images_upload_handler: function (blobInfo, success, failure) {
                    var xhr, formData;
                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', '{{ route("panel.blog-manage.form.editorUpload") }}');
                    var token = '{{ csrf_token() }}';
                    xhr.setRequestHeader("X-CSRF-Token", token);
                    xhr.onload = function () {
                        var json;
                        if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }
                        json = JSON.parse(xhr.responseText);

                        if (!json || typeof json.location != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        success(json.location);
                    };
                    formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);
                },
                setup: function (editor) {
                    editor.on('change', function () {
                        tinymce.triggerSave();
                    });
                }
            })
        })
    </script>
@endsection
