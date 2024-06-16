@extends('layouts.app')
@section('title', 'View Users')
@section('content')
    <style>
        .header {
            color: rgb(2, 2, 2);
        }

        .corner {
            border-radius: 7px;
            text-align: center;
        }

        .groupedInput {
            border: 1px solid #e1cdcd;
            border-radius: 7px;
            /*border-radius: 10px;*/
        }

        .spacer {
            margin-top: 20px;
        }

        .groupedLabel {
            margin-top: 7px;
            color: rgb(153, 153, 153);
        }

        .example-table tr:nth-child(2n+1) {
            background-color: #ddd;
        }

        .example-table tr:nth-child(2n+0) {
            background-color: #eee;
        }

        .action {
            color: rgb(167, 169, 172);
            font-family: 'Roboto Light';
        }

        .image-size {
            width: 1.5em;
            height: 1.5em;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h3 class="header">{{translate('View')}} {{translate('users')}}</h3>
                        </div>
                    </div>
                    <form action="{{ route('users.index') }}" method="get" class="bg-none">
                        <div class="col-md-12 row text-center spacer">
                            <div class="col-md-2"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="section" class="form-control select2" id="brand" style="width: 100%">
                                        <option value="">{{translate('Select')}} {{translate('Section')}}</option>
                                        @foreach (getAllSections() as $section)
                                            <option value="{{ $section->value }}"
                                                {{ request()->get('section') == $section->value ? 'selected' : '' }}>
                                                {{ $section->text }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button class="form-control">{{translate('Submit')}}</button>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group" >
                                    <x-url-param-clear></x-url-param-clear>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body p-0 spacer" style="overflow-x: auto" >
                    <table class="table table-striped table-responsive example-table">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>{{translate('Section')}}</th>
                                <th>{{translate('Name')}}</th>
                                <th>{{translate('Designation')}}</th>
                                <th>{{translate('Store')}} {{translate('Access')}}</th>
                                <th>{{translate('Status')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $value)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $value->section->name ?? '' }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->designation->name ?? '' }}</td>
                                    <td>
                                        {{ $value->branch->name ?? '' }}
                                    </td>
                                    <td>
                                        @if ($value->status == 1)
                                            <span class="label label-success">{{translate('Active')}}</span>
                                        @else
                                            <span class="label label-danger">{{translate('Inactive')}}</span>
                                        @endif

                                    </td>
                                    <td class="action">
                                        <img class="image-size" src="{{ asset('images/sales/02.png') }}" alt="edit" />
                                        <a href="{{ route('users.edit', $value->id) }}"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="9">
                                        <h4 class="font-weight-bold">{{translate('No')}} {{translate('User')}} {{translate('available')}}</h4>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
    </div>
    </section>
    </div>

@endsection
