@extends('Backend.Layout.master')
@section('title', 'Blog Yazıları')
@section('cssBefore')

@endsection
@section('cssAfter')
    <link href="{{ asset("backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("backend/assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css") }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Blog Yazı Listesi</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Blog Yazı Listesi</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Blog Yazı Listesi</h3>
                    <div class="row">
                        <div class="col-12 text-right">
                            <a href="{{ route('panel.blog-manage.form.index') }}" class="btn btn-success">Yeni Blog Yazısı</a>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="datatable">
                                    <thead class="bg-dark text-white">
                                    <tr>
                                        <th>ID</th>
                                        <th>Kapak Resmi</th>
                                        <th>Başlık</th>
                                        <th>Yayın Durumu</th>
                                        <th>Yazı Tarihi</th>
                                        <th>İşlemler</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection
@section('jsBefore')

@endsection
@section('jsAfter')
    <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/datatable.js') }}"></script>
    <script>
        function destroy(id) {
            Swal.fire({
                title: 'Kategoriyi Silmekmi İstiyorsun',
                html: "Kategoriyi <b>siliyorsun geri dönüşü olmayacak !</b>",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'İptal Et',
                confirmButtonText: 'Evet, silmek istiyorum.'
            }).then((result) => {
                if(result.value == true && id > 0){
                    $.ajax({
                        url: "/panel/category-manage/destroy/"+id,
                        method: "GET",
                        success: function(res) {
                            if(parseInt(res.statusCode) > 0)
                            {
                                toastr.success(res.statusMessage)
                                setTimeout(function (){
                                    window.location.href="{{ route('panel.category-manage.list.index') }}";
                                }, 1900)
                            }else {
                                toastr.error(res.statusMessage)
                            }
                        }
                    })
                }

            })
        }
    </script>
@endsection
