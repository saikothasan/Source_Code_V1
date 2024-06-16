@extends('layouts.app')
@section('title', 'Update User')
@section('content')

    @push('css')
        <style>
            .supplier_content {
                text-align: center;
            }

            .form-control {
                border-radius: 7px;
                box-shadow: none;
                border-color: #06cdffd6 !important;
                height: 50px;
            }


            ::-webkit-input-placeholder {
                text-align: center;
            }

            :-moz-placeholder { /* Firefox 18- */
                text-align: center;
            }

            ::-moz-placeholder { /* Firefox 19+ */
                text-align: center;
            }

            :-ms-input-placeholder {
                text-align: center;
            }

            .image img {
                width: 102px;
                border-radius: 50px;
            }

            .image input {
                margin-left: 37%;
                margin-top: 23px;
            }


        </style>
    @endpush
    <div class="content-wrapper">

        <div class="content supplier_content">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <h2><strong> {{translate('User')}} {{translate('Update')}}</strong></h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{route('users.update',$user->id)}}" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="box-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select name="section" class="form-control select2" id="supplier"
                                            style="width: 100%">
                                        <option value="">{{translate('Select')}} {{translate('Section')}}</option>
                                        @foreach (getAllSections() as $section)
                                            <option
                                                value="{{$section->value}}" {{ $user->section_id ==$section->value ? 'selected' : ''  }}>
                                                {{$section->text}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('section')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select name="designation" class="form-control select2" id="supplier"
                                            style="width: 100%">
                                        <option value="">{{translate('Select')}} {{translate('Designation')}}</option>
                                        @foreach (getAllDesignation() as $department)
                                            <option
                                                value="{{$department->value}}" {{ $user->designation_id ==$department->value ? 'selected' : ''  }}>
                                                {{$department->text}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('designation')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" value="{{old('username',$user->username)}}" name="username" class="form-control"
                                           placeholder="User Name">
                                    @error('username')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="name" value="{{old('name',$user->name)}}" class="form-control" id=""
                                           placeholder="Full Name">
                                    @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="phone" value="{{old('phone',$user->phone)}}" class="form-control" id=""
                                           placeholder="Phone Number">
                                    @error('phone')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="email" value="{{old('email',$user->email)}}" class="form-control" id=""
                                           placeholder="Email Address">
                                    @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="address" value="{{old('address',$user->address)}}" class="form-control" id="" placeholder="Address">
                                    @error('address')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
{{--                            <div class="form-group">--}}
{{--                                <div class="col-sm-6">--}}
{{--                                    <input type="password" name="password" value="{{old('password')}}" class="form-control" id=""--}}
{{--                                           placeholder="Password">--}}
{{--                                    @error('password')--}}
{{--                                    <span class="text-danger">{{$message}}</span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-6">--}}
{{--                                    <input type="password" name="password_confirmation" value="{{old('password')}}" class="form-control" id=""--}}
{{--                                           placeholder="Confirm Password">--}}
{{--                                    @error('password_confirmation')--}}
{{--                                    <span class="text-danger">{{$message}}</span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select name="branch_id"
                                            class="form-control select2" id="" style="width: 100%;">
                                        <option value="" selected>{{translate('Select')}} {{translate('Branch')}}</option>
                                        @foreach (getAllBranch() as $key => $branch)
                                            <option value="{{$branch->value}}" {{ $user->branch_id === $branch->value ? 'selected' : ''  }}>
                                                {{$branch->text}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select name="permission_id[]" data-placeholder="Select Permission"
                                            class="form-control select2" id="" style="width: 100%;" multiple>
                                        @foreach ($permissions as $key => $permission)
                                            <option value="{{ $permission->id }}" @if (in_array($permission->id, $userPermission))
                                                {{ 'selected' }}
                                                @endif >{{ $permission->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group image">
                                <img src="{{ asset($user->photo) }}"  style="border-radius: 100%;" id="user_photo"
                                     alt="">
                                <div class="col-sm-12">
                                    <input type="file" name="photo" onchange="readPicture(this)"
                                           placeholder="Add Images">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-default" style="background:#29B473">{{translate('Submit')}}</button>
                    </form>
                </div>
                <div class="col-md-4"></div>

            </div>


        </div>

    </div>
@endsection

@push('js')
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
@endpush
