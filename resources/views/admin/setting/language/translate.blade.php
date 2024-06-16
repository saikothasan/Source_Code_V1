@extends('layouts.app')
@section('title', 'Language')

@push('css')
@endpush

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">

                <div class="row __mt-20">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ translate('language_content_table') }}</h5>
                                <a href="{{ route('language.index') }}"
                                    class="btn btn-sm btn-danger btn-icon-split float-right">
                                    <span class="text text-capitalize">{{ translate('back') }}</span>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="card-body spacer" style="overflow-x: auto">
                                    <table class="table table-striped table-responsive example-table">
                                        <thead>
                                            <tr>
                                                <th>{{ translate('SL') }}#</th>
                                                <th style="width: 2%">{{ translate('key') }}</th>
                                                <th style="min-width: 300px">{{ translate('value') }}</th>
                                                {{-- <th>{{ translate('auto_translate') }}</th> --}}
                                                <th>{{ translate('Update') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php($count = 0)
                                            @foreach ($full_data as $key => $value)
                                                @php($count++)
                                                <tr id="lang-{{ $count }}">
                                                    <td>{{ $count }}</td>
                                                    <td style="width:10%">
                                                        @php($key = \App\Services\TranslateService::remove_invalid_charcaters($key))
                                                        <input type="text" name="key[]" value="{{ $key }}"
                                                            hidden>
                                                        <label>{{ $key }}</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="value[]"
                                                            id="value-{{ $count }}" value="{{ $value }}">
                                                    </td>
                                                    {{-- <td class="__w-100px">
                                                        <button type="button"
                                                            onclick="auto_translate('{{ $key }}',{{ $count }})"
                                                            class="btn btn-ghost-success btn-block"><i
                                                                class="tio-globe"></i>
                                                        </button>
                                                    </td> --}}
                                                    <td class="__w-100px">
                                                        <button type="button"
                                                            onclick="update_lang('{{ $key }}',$('#value-{{ $count }}').val())"
                                                            class="btn btn--primary btn-block"> {{translate('Update')}}
                                                        </button>
                                                    </td>
                                                    <td class="__w-100px">
                                                        <button type="button"
                                                            onclick="remove_key('{{ $key }}',{{ $count }})"
                                                            class="btn btn-danger btn-block"><i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection

        @push('js')
            <!-- Page level plugins -->
            <!-- Page level custom scripts -->
            <script>
                // Call the dataTables jQuery plugin


                function update_lang(key, value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('language.translate-submit', [$lang]) }}",
                        method: 'POST',
                        data: {
                            key: key,
                            value: value
                        },
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        success: function(response) {
                            toastr.success('{{ translate('text_updated_successfully') }}');
                        },
                        complete: function() {
                            $('#loading').hide();
                        },
                    });
                }

                function remove_key(key, id) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('language.remove-key', [$lang]) }}",
                        method: 'POST',
                        data: {
                            key: key
                        },
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        success: function(response) {
                            toastr.success('{{ translate('Key removed successfully') }}');
                            $('#lang-' + id).hide();
                        },
                        complete: function() {
                            $('#loading').hide();
                        },
                    });
                }

                function auto_translate(key, id) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('language.auto-translate', [$lang]) }}",
                        method: 'POST',
                        data: {
                            key: key
                        },
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        success: function(response) {
                            toastr.success('{{ translate('Key translated successfully') }}');
                            console.log(response.translated_data)
                            $('#value-' + id).val(response.translated_data);
                            //$('#value-' + id).text(response.translated_data);
                        },
                        complete: function() {
                            $('#loading').hide();
                        },
                    });
                }
            </script>
        @endpush
