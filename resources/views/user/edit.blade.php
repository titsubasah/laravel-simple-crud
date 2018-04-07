<html>
<head>
    <title>Edit</title>
    <link rel="stylesheet" href="{{ url('plugins/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}">
</head>
<body>
<div class="container">
	{{ HTML::ul($errors->all()) }}
        <!-- <form id="form-edit" class="form-horizontal" role="form" method="POST" action="{{ url('/user') }}/{{$user->uuid}}"> -->
		<!-- If success -->
		@if (Session::has('flash_message'))
			<div class="alert alert-success">
				<p>
					<i class="fa fa-check"></i> {!! Session::get('flash_message') !!} 
				</p>
			</div>
		@endif
		{!! Form::model($user, ['class'=>'form-horizontal', 'method'=>'PATCH', 'route' => ['user.update', $user->uuid]]) !!}
		<form  id="form-edit" class="form-horizontal" method="POST" action="{{ url('/user') }}/{{$user->uuid}}" accept-charset="UTF-8">
            <h1>Form Edit {{ $user->nama }} </h1>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label class="col-md-4 control-label">ID</label>
                <div class="col-md-6">
                    <input disabled type="text" class="form-control" id="uuid" name="uuid" value="{{ $user->uuid }}">                    
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Nama</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $user->nama }}">                    
                        <div class="error"><span id = "nama-error"></span></div>                    
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Alamat</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $user->alamat }}">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                </div>
            </div>
        </form>
</div>

</body>