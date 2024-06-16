@extends('layouts.app')
@section('title', 'Language')

@push('css')
    <!-- Custom styles for this page -->
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 23px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #377dff;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #377dff;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endpush

@section('content')
    <div class="content-wrapper">
        <section class="content">



            <!-- Page Heading -->
            <div class="d-md-flex_ align-items-center justify-content-between mb-2">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="h3 mb-0 text-black-50">{{ translate('Language') }}</h3>
                    </div>

                    <div class="col-md-4">
                        <button class="btn btn-primary btn-icon-split float-right" data-toggle="modal"
                            data-target="#lang-modal">
                            <i class="tio-add-circle"></i>
                            <span class="text">{{ translate('Add') }} {{ translate('New') }} {{ translate('Language') }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 20px">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-body spacer" style="overflow-x: auto">
                            <table class="table table-striped table-responsive example-table">
                                <thead>
                                    <tr>
                                        <th>{{ translate('SL') }}#</th>
                                        <th>{{ translate('Id') }}</th>
                                        <th>{{ translate('Name') }}</th>
                                        <th>{{ translate('Code') }}</th>
                                        <th>{{ translate('status') }}</th>
                                        <th class="text-right">{{ translate('action') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($language = App\Model\Setting::where('key', 'language')->first())

                                    @foreach (json_decode($language['value'], true) as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data['id'] }}</td>
                                            <td>{{ $data['name'] }}

                                            </td>
                                            <td>{{ $data['code'] }}</td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox"
                                                        onclick="updateStatus('{{ route('language.update-status') }}','{{ $data['code'] }}')"
                                                        class="status" {{ $data['status'] == 1 ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox"
                                                        onclick="window.location.href ='{{ route('language.update-default-status', ['code' => $data['code']]) }}'"
                                                        class="status"
                                                        {{ array_key_exists('default', $data) && $data['default'] == true ? 'checked' : (array_key_exists('default', $data) && $data['default'] == false ? '' : 'disabled') }}>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <button class="btn btn-seconary btn-sm dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="fa fa-cog"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @if ($data['code'] != 'en')
                                                            <li>
                                                                <a class="dropdown-item" data-toggle="modal"
                                                                    data-target="#lang-modal-update-{{ $data['code'] }}">{{ translate('update') }}</a>
                                                            </li>
                                                            @if ($data['default'] == true)
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:"
                                                                        onclick="default_language_delete_alert()">{{ translate('Delete') }}</a>
                                                                </li>
                                                            @else
                                                                <li>
                                                                    <a class="dropdown-item delete"
                                                                        id="{{ route('language.delete', [$data['code']]) }}">{{ translate('Delete') }}</a>
                                                                </li>
                                                            @endif
                                                        @endif
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('language.translate', [$data['code']]) }}">{{ translate('Translate') }}</a>
                                                        </li>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>




                        <div class="modal fade" id="lang-modal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ translate('new_language') }}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('language.add-new') }}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="recipient-name"
                                                    class="col-form-label">{{ translate('language') }}
                                                </label>
                                                <input type="text" class="form-control" id="recipient-name"
                                                    name="name">
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text"
                                                    class="col-form-label">{{ translate('language_code') }}</label>
                                                <select class="form-control" name="code">
                                                    @foreach (\Illuminate\Support\Facades\File::files(base_path('public/images/flags')) as $path)
                                                        <img src="{{ asset('images/flags/' . pathinfo($path)['filename'] . '.png') }}"
                                                            alt="">
                                                        <option value="{{ pathinfo($path)['filename'] }}"
                                                            data-flag="{{ asset('images/flags/' . pathinfo($path)['filename'] . '.png') }}">
                                                            {{ strtoupper(pathinfo($path)['filename']) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{ translate('close') }}</button>
                                            <button type="submit" class="btn btn-primary">{{ translate('Add') }} <i
                                                    class="fa fa-plus"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @foreach (json_decode($language['value'], true) as $key => $data)
                            <div class="modal fade" id="lang-modal-update-{{ $data['code'] }}" tabindex="-1"
                                role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                {{ trans('new_language') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('language.update') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="recipient-name"
                                                                class="col-form-label">{{ trans('language') }}
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $data['name'] }}" name="name">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="message-text"
                                                                class="col-form-label">{{ trans('country_code') }}</label>
                                                            <select class="form-control country-var-select w-100"
                                                                name="code">
                                                                @foreach (\Illuminate\Support\Facades\File::files(base_path('public/images/flags')) as $path)
                                                                    @if (pathinfo($path)['filename'] != 'en' && $data['code'] == pathinfo($path)['filename'])
                                                                        <option value="{{ pathinfo($path)['filename'] }}"
                                                                            title="{{ asset('/images/flags/' . pathinfo($path)['filename'] . '.png') }}">
                                                                            {{ strtoupper(pathinfo($path)['filename']) }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">{{ trans('direction') }}
                                                                :</label>
                                                            <select class="form-control" name="direction">
                                                                <option value="ltr"
                                                                    {{ isset($data['direction']) ? ($data['direction'] == 'ltr' ? 'selected' : '') : '' }}>
                                                                    LTR
                                                                </option>
                                                                <option value="rtl"
                                                                    {{ isset($data['direction']) ? ($data['direction'] == 'rtl' ? 'selected' : '') : '' }}>
                                                                    RTL
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">{{ trans('close') }}</button>
                                                <button type="submit" class="btn btn--primary">{{ trans('update') }} <i
                                                        class="fa fa-plus"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
        </section>
    </div>



@endsection

@push('js')
    <!-- Page level custom scripts -->
    <script>
        function updateStatus(route, code) {
            $.get({
                url: route,
                data: {
                    code: code,
                },
                success: function(data) {
                    /* console.log(data)*/
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $(".delete").click(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: '{{ translate('Are you sure to delete this') }}?',
                    text: "{{ translate('You will not be able to revert this') }}!",
                    showCancelButton: true,
                    confirmButtonColor: 'primary',
                    cancelButtonColor: 'secondary',
                    confirmButtonText: '{{ translate('Yes') }}, {{ translate('delete') }}!'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = $(this).attr("id");
                    }
                })
            });
        });
    </script>
    <script>
        function default_language_delete_alert() {
            toastr.warning(
                '{{ translate('default language can not be deleted! to delete change the default language first!') }}'
            );
        }
    </script>
@endpush
