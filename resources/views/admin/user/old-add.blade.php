@extends('layouts.app')
@section('title', 'New User Add')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('users.index')}}"><i class="fa fa-group"></i> Users</a></li>
            <li class="active">New User</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (user header) -->
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">New User</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('users.index')}}" class="btn btn-sm bg-green"><i class="fa fa-list"></i> User List</a>
                        </div>		
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                    	@include('includes.errormessage')
                    	<form action="{{route('users.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    		@csrf
                            <div class="form-group">
                                <label class="control-label col-md-2">Name</label>
                                <div class="col-sm-9">
                                    <input name="name" placeholder="name" class="form-control" required="" type="text" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Username</label>
                                <div class="col-sm-9">
                                    <input name="username" placeholder="Username" class="form-control" required="" type="text" value="{{ old('username') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">E-mail Address</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" placeholder="E-mail Address" name="email" value="{{old('email')}}" required="">
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Phone</label>
                                <div class="col-sm-9">
                                    <input name="phone" placeholder="Phone" class="form-control" type="text" value="{{ old('phone') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" placeholder="Password" name="password" value="{{old('password')}}" required="">
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Confirm Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" placeholder="Password" name="password_confirmation" required="" value="{{old('password')}}">
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Address</label>
                                <div class="col-sm-9">
                                    <textarea name="address" rows="3" class="form-control" placeholder="Address" style="resize: vertical;">{{old('address')}}</textarea>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Permissions</label>
                                <div class="col-sm-9">
                                    <select name="permission_id[]" class="form-control select2" id="" style="width: 100%;" required="" multiple> 
                                        @foreach ($permissions as $key => $permission)
                                            <option value="{{$permission->id}}">{{$permission->name}}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Photo</label>
                                <div class="col-sm-9">
                                    <input type="file" name="photo" onchange="readPicture(this)">
                                </div>
                            </div>
	                        <div class="col-md-12">
	                        	<center>
                                    <img src="//placehold.it/200x200" alt="user Photo" id="user_photo">
                                    <br> <br>
	                        		<button type="reset" class="btn btn-sm bg-red">Reset</button>
	                        		<button type="submit" class="btn btn-sm bg-blue">Save</button>
	                        	</center>
	                        </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    // profile picture change
    function readPicture(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
    
          reader.onload = function (e) {
            $('#user_photo')
            .attr('src', e.target.result)
            .width(200)
            .height(200);
        };
    
        reader.readAsDataURL(input.files[0]);
    }
    }
    
</script>