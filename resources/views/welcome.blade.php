<html>
<head>
    <title>Web Test App</title>
    <link rel="stylesheet" href="{{ url('plugins/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}">
</head>
<body>
    <div class="container">
        <form id="form-registrasi" class="form-horizontal" role="form" method="POST" action="{{ url('/user') }}">
            <h3>Form Registrasi</h3>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" readonly class="form-control" id="id" name="id" value="">            
            <div class="form-group">
                <label class="col-md-4 control-label">ID</label>
                <div class="col-md-6">
                    <input type="text" readonly class="form-control" id="uuid" name="uuid" value="{{ old('uuid') }}">                    
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Nama</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}">                    
                        <div class="error alert-danger"><span id="nama-error"></span></div>                    
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Alamat</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat') }}">
                    <div class="error alert-danger"><span id="alamat-error"></span></div>                    
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
        <h3>Daftar User</h3>
        <table class="table table-bordered" id="table-user">
            <thead>
                <tr>
                    <th>ID Customer</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $row)
                <tr>
                    <td>{{ $row->uuid }}</td>
                    <td>{{ $row->nama }}</td>
                    <td>{{ $row->alamat }}</td>
                    <td>                        
                        <button class="edit btn btn-success" type="button" data-uuid="{{ $row->uuid }}" type="button" >Edit</button>
                        <!-- <a id="delete" data-toggle="modal" type="button"  href="#modal-delete"  data-uuid="{{ $row->uuid}}" class="btn btn-danger">Delete</a>    -->
                        <button class="delete-modal btn btn-danger" data-id="{{ $row->id }}"> Hapus </button>                    
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Apakah anda yakin?</h3>
                    <!-- <input type="hidden"  class="form-control" id="id_delete" disabled> -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger delete" data-dismiss="modal">Hapus</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ url('plugins/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url('plugins/bootstrap-3.3.7-dist/js/bootstrap.min.js') }}"></script>

    <script>
        $( document ).ready(function() {
            var rand = function() {
                return Math.random().toString(36).substr(2);
            };

            var token = function() {
                return rand() + rand(); 
            };
            var uuid = $("#uuid").val(token());
            
            $("#form-registrasi").submit(function(e) {
                var form_data = $("#form-registrasi").serialize()
                console.log(form_data);
                var url = "{{ url('/user') }}";                
                $.ajax({
                       type: "POST",
                       url: url,
                       data: form_data, 
                       success: function(data)
                       {
                        $("#nama-error").empty();
                        $("#alamat-error").empty();                           
                           if(data.error === true){                                
                                var errors = data.error_list;                                                            
                                $("#nama-error").append(errors.nama);
                                $("#alamat-error").append(errors.alamat);                                
                           }
                           if(data.user){
                               var edit_url = url + '/' + data.user.uuid + '/edit'
                               var delete_url = url + '/' + data.user.uuid + '/delete'
                                row = '<tr>'+
                                    '<td>'
                                    +
                                        data.user.uuid
                                    +
                                    '</td>'
                                    +
                                    '<td>'
                                    +
                                        data.user.nama
                                    +
                                    '</td>'
                                    +
                                    '<td>'
                                    +
                                        data.user.alamat
                                    +
                                    '</td>'
                                    +
                                    '<td>'
                                    +
                                    '<button class="edit btn btn-success" type="button" data-uuid="'+data.user.uuid+'" type="button" >Edit</button>'                                    
                                    +
                                    '<button class="delete-modal btn btn-danger" data-id="'+data.user.id+'"> Hapus </button>'
                                    +
                                    '</td>'
                                '</tr>';
                                $('#table-user tr:last').after(row);
                           }
                           alert(data.flash_message);
                       }
                     });
                $("#uuid").val(token());

                e.preventDefault();                
                clear_form();
                     
            });                        
            $(document).on('click', '.edit', function() {                            
                var uuid = $(this).data('uuid');
                var url = "{{ url('/user') }}/" + uuid + "/edit";
                clear_message();
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $("#id").val(data.id);
                        $("#uuid").val(data.uuid);
                        $("#nama").val(data.nama);
                        $("#alamat").val(data.alamat);
                    }
                });
            });

            function clear_form(){
                $("#nama").val("");
                $("#alamat").val("");
            }

            function clear_message(){
                $("#nama-error").empty();
                $("#alamat-error").empty();     
            }



        $(document).on('click', '.delete-modal', function() {
                
        
        $('#deleteModal').modal('show');
            id = $(this).data('id');            
        });
        $('.modal-footer').on('click', '.delete', function() {
            var url = "{{ url('/user') }}/" + id;
            $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    '_token': $('input[name=_token]').val(),
                },
                success: function(data) {
                    alert(data.flash_message);
                    location.reload();
                }
            });
        });
        });

        
    </script>
</body>
</html>