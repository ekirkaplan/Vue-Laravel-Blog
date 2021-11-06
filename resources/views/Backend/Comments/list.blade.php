@extends('Backend.Layout.master')
@section('title', 'Kategori Listesi')
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
                <h4 class="mb-0">Yorum Listesi</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Yorum Listesi</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Yorum Listesi</h3>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="datatable">
                                    <thead class="bg-dark text-white">
                                    <tr>
                                        <th>ID</th>
                                        <th>Blog Yazısı</th>
                                        <th>E-Posta</th>
                                        <th>İsim</th>
                                        <th>Yayın Durumu</th>
                                        <th>İşlemler</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->blog->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                @if ($item->status > 0)
                                                    <a href="{{ route('panel.comment-manage.list.swap', $item->id) }}" class="badge badge-success">Yayında</a>
                                                @else
                                                    <a href="{{ route('panel.comment-manage.list.swap', $item->id) }}" class="badge badge-danger">Onay Bekliyor</a>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button data-toggle="modal" data-target="#categoryEdit{{ $item->id }}" class="btn btn-success btn-sm">Detay</button>
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="categoryEdit{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Yorum Detayı</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                        <div class="modal-body">
                                                            <p>{{ $item->content }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yeni Kategori Oluştur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('panel.category-manage.list.process') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="name">Kategori Adı</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Kategori Adı" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="statuss">Yayın Durumu</label>
                                <select name="status" class="form-control" id="statuss">
                                    <option value="1">Yayında</option>
                                    <option value="0">Pasif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn btn-primary">Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->

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
