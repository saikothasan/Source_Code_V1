@extends('layouts.app')
@section('title', 'New Bank')
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
                    <h2><strong> {{translate('Add')}} {{translate('Bank')}}
                    </strong></h2>
                    <form class="form-horizontal" action="{{route('banks.store')}}" method="POST"
                          class="form-horizontal" >
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="name" class="form-control" id="" value="{{ old('name') }}"
                                           placeholder="{{translate('Bank')}} {{translate('Name')}}">
                                    @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="account_no" class="form-control" value="{{ old('account_no') }}"
                                           id="" placeholder="{{translate('Account')}} {{translate('Number')}}">
                                    @error('account_no')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-12">
                                <select class="form-control select2" name="user_id">
                                    <option value="">{{translate('Select')}} {{translate('User')}}</option>
                                    @foreach ($users as $user )

                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach

                                </select>
                                @error('user_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                                </div>

                            </div>
                           <center>
                            <div class="form-group">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <input type="number" name="amount" class="form-control" value="{{ old('amount',0) }}"
                                           id="" placeholder="0,000">
                                           <h4><strong style="color: black">{{translate('Available')}} {{translate('Amount')}}</strong></h4>
                                    @error('amount')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                           </center>



                        </div>
                        <div class="row text-center form-group mt-5">
                            <div class="col-md-4"></div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-success" style="width: 100%;">{{translate('Submit')}}</button>

                            </div>

                            <div class="col-md-4">
                                <a href="{{ route('banks.index') }}">
                                    <button type="button" class="btn btn-orange" style="width: 100%;">{{translate('View')}} {{translate('Bank')}}</button>
                                </a>
                            </div>
                        </div>

                </div>


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
                    $('#supplier_photo')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(200);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>

@endpush
