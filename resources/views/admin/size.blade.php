@extends('layouts.app')
@section('title', 'Size')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('sizes.index')}}"><i class="fa fa-group"></i> Size</a></li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (user header) -->
                <div class="box box-teal box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Size</h3>
                        <div class="box-tools pull-right">
                        	<a href="#" class="btn btn-sm bg-green" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> New Size</a>
                        </div>		
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" id="box-body">
                    	@include('includes.errormessage')
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 15%">Sl.</th>
                                    <th style="width: 70%">Name</th>
                                    <th style="width: 15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sizes as $key => $size)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$size->name}}</td>
                                    <td>
                                    	<a class="btn btn-sm bg-teal" href="#" data-toggle="modal" data-target="#edit-modal" data-id="{{$size->id}}" data-name="{{$size->name}}"><span class="glyphicon glyphicon-edit"></span></a>

                                    	<form action="{{route('sizes.destroy',$size->id)}}" method="post" style="display: none;" id="delete-form-{{ $size->id}}">
                                            @csrf
                                            {{method_field('DELETE')}}
                                        </form>
                                        <a class="btn btn-sm bg-red" href="" onclick="if(confirm('Are You Sure To Delete?')){
                                            event.preventDefault();
                                            getElementById('delete-form-{{ $size->id}}').submit();
                                            }else{
                                            event.preventDefault();
                                            }"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">New size</h4>
        </div>
        <div class="modal-body">
            <form action="{{route('sizes.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="control-label col-md-2">Name</label>
                    <div class="col-sm-9">
                        <input name="name" placeholder="name" class="form-control" required="" type="text" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <center>
                        <button type="reset" class="btn btn-sm bg-red" data-dismiss="modal">Reset</button>
                        <button type="submit" class="btn btn-sm bg-teal">Save</button>
                    </center>
                </div>
            </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
      
    </div>
</div>

<div class="modal fade" id="edit-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">size Update</h4>
        </div>
        <div class="modal-body">
            <form id="edit-form" method="POST" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="control-label col-md-2">Name</label>
                    <div class="col-sm-9">
                        <input name="name" id="name" placeholder="name" class="form-control" required="" type="text" value="{{ old('name') }}">
                        <input type="hidden" name="id" id="id">
                    </div>
                </div>
                <div class="col-md-12">
                    <center>
                        <button type="reset" class="btn btn-sm bg-red" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm bg-teal">Update</button>
                    </center>
                </div>
            </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
      
    </div>
</div>

  <script type="text/javascript">
    $('#edit-modal').on("show.bs.modal", function(event){

        var e             = $(event.relatedTarget);
        var id            = e.data('id');
        var name          = e.data('name');

        var action = '{{URL::to('admin/sizes/update')}}';
 
        $("#edit-form").attr('action', action);
        $("#id").val(id);
        $("#name").val(name);

    });
</script>
@endsection