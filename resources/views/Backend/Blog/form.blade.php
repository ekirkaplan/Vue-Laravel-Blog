@extends('Backend.Layout.master')
@section('title', $data->id > 0 ? 'Blog Yazısını Güncelle' : 'Blog Yazısı Ekle')
@section('cssBefore')
    <link href="{{ asset('backend/assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('cssAfter')
    <style>

        img.blogImage {
            top: 3px;
            position: absolute;
            width: 90%;
            left: 50%;
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%);
        }

        div.dropzone {
            position: relative;
            color: white !important;
            height: 230px !important;
        }

        div.dropzone:before {
            content: " ";
            position: absolute;
            background: rgba(0, 0, 0, 0.5);
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            z-index: 1;
        }

        .uploadText {
            position: relative;
            position: relative;
            z-index: 3;
        }

        .dropzone .dz-preview .dz-image {
            width: unset;
            height: unset;
        }

        .dropzone .dz-preview {
            margin: 0 !important;
            max-width: 100% !important;

        }

        .dropzone .dz-preview .dz-image img {
            max-width: 100%;
        }

        .data-dz-remove {
            width: 50px;
            background: rgba(0,0,0,0.4);
            font-size: 29px;
            position: relative;
            top: -133px;
            z-index: 500;
            color: red;
            margin: 0 auto;
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
        <form style="display: flex;width: 95%; margin: 0 auto" id="form" action="">
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
                                <input type="date" class="form-control" id="streamDate" name="streamDate" value="{{ $data->id > 0 ? $data->streamDate : now()->format('Y-m-d') }}">
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
                                        <div class="dropzone" id="galleryDropZone">
                                            @if ($data->id > 0)
                                                <img src="{{ asset(\App\Models\Gallery::find($data->img)->img) }}" class="blogImage" alt="">
                                            @else
                                                <img src="{{ asset('backend/assets/images/authentication-bg.jpg') }}" class="blogImage" alt="">
                                            @endif
                                            <div class="fallback">
                                                @csrf
                                                <input name="file" type="file">
                                            </div>
                                            <div class="dz-message needsclick">
                                                <div class="mb-3 uploadText">
                                                    <i class="display-4 text-white ri-upload-cloud-2-line"></i>
                                                </div>

                                                <h4 class="text-white uploadText">Tıkla Veya Resmi Sürükle</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="mainImg" value="{{ $data->id > 0 ? $data->img : 0 }}" name="img">

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
                                        <button class="btn btn-success w-100" type="button" id="sendButton" onclick="sendForm()">{{ $data->id > 0 ? 'Güncelle' : 'Kaydet' }}</button>
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
    <script src="{{ asset('backend/assets/libs/dropzone/min/dropzoneTwo.min.js') }}"></script>+
    <script src="{{ asset('backend/assets/libs/validate/validate.min.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;

        function sendForm() {
            $("#form").submit();
        }

        $("#form").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 4
                },
                streamDate: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Blog Adını Girmediniz",
                    minlength: "Blog Adı En Az 4 Karakter Olmalıdır",
                },
                streamDate: {
                    required: "Yayın Tarihini Girmediniz !",
                },
            },
            submitHandler: function (form) {
               // $("#loginButton").prop('disabled', true);
                // validate
                var validateStatus = 0;
                var processStatus = {!! $data->id > 0 ? 1 : 0 !!};
                var imgStatus = parseInt($("#mainImg").val())
                console.log(imgStatus);
                if (imgStatus < 1){
                    validateStatus = 10;
                    toastr.error('Kapak Resmi Seçmediniz');
                }
                var categoryStatus = $(".categorySwitch").is(':checked');
                if (categoryStatus === false){
                    toastr.error('Hiç Kategori Seçmediniz!');
                    validateStatus = 10;
                }

                if (validateStatus < 1){
                    $("#sendButton").prop('disabled', true);
                    $.ajax({
                        url: "{{ route('panel.blog-manage.form.process', $data->id) }}",
                        method: "POST",
                        data: $("#form").serialize(),
                        success: function (res) {
                            if (parseInt(res.statusCode) > 0) {
                                toastr.success(res.statusMessage);
                                setTimeout(function () {
                                    window.location.href = "{{ route('panel.blog-manage.list.index') }}";
                                }, 1900)
                            } else {
                                toastr.error(res.statusMessage);
                                $("#sendButton").prop('disabled', false);
                            }
                        }
                    });
                }
                // validate End
            }
        });


        Dropzone.options.galleryDropZone = {
            thumbnailHeight: 200,
            thumbnailWidth: null,
            addRemoveLinks: false,
            thumbnailMethod: "contain",
            dictRemoveFile: '<div class="data-dz-remove"><i class="fas fa-ban"></i></div>',
            init: function () {

                this.on("removedfile", function () {
                    $("#mainImg").val(null);
                });

                this.on("addedfile", function () {
                    if (this.files[1] != null) {
                        this.removeFile(this.files[0]);
                    }
                });
                this.on("success", function (response) {
                    if (response.xhr.response > 0) {
                        toastr.success('Resim Başarılı Bir Şekilde Eklendi');
                        $("#mainImg").val(response.xhr.response);
                    } else {
                        toastr.error('Resim Eklenemedi Resim 3MB Geçmemeli !!!');
                    }
                });
            }
        };

        $(document).ready(function () {
            $(".dropzone").dropzone({
                url: "{{ route('panel.blog-manage.form.addPhoto') }}", headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            });
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
