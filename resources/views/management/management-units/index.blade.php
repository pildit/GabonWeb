@extends('layouts.app')

@section('title', 'Management Unit')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                THE MAP
            </div>
            @verbatim
                <div class="col-md-8" id="management-unit-grid">
                    <div class="mt-4">
                        <h5 class="text-center green-text mb-2">{{translate('management_unit_title')}}</h5>
                        <div class="row">
                            <div class="col-sm-8 d-flex align-items-center">
                                <a class="btn btn-md" :href="createRoute()">
                                    <i class="fas fa-plus-circle"></i> {{translate('add_management_unit')}}
                                </a>
                            </div>
                            <div class="md-form col-sm-4">
                                <div class="form-row justify-content-end">
                                    <div class="col-sm-10">
                                        <label for="company_name">{{translate('Search')}}</label>
                                        <input @keyup.enter="fetchData" class="form-control" v-model="search" type="text" Placeholder="" name="management_unit_name" id="management_unit_name" />
                                    </div>
                                    <button @click="fetchData" class="btn btn-sm btn-green  px-2" id="filter">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <grid :columns="grid.columns" :options="grid.options"></grid>
                    </div>
                </div>
            @endverbatim
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Management.ManagementUnit.render('management-unit-grid');
        });
    </script>
@endsection
