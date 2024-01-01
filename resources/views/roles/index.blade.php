@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Role List') }}
                    <button class="btn btn-primary btn-sm float-end" onclick="addItemModel(this, '{{ @$createRoute }}');">
                        <ion-icon name="add-outline"></ion-icon> Add
                    </button>
                </div>
                <div class="card-body">
                    <table class="table" id="dataTable">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('page-script')
    <script>
        $(document).ready(function() {
            var columns = [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];


            listDatatable(this, "{{ route('admin.role.index')}}", columns)
        });
    </script>
    @endsection