@extends('layouts.app')

@section('title', @lang('management_unit'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div id="geoportalpage" class="col-md-4" style="position: fixed; padding: 10px">
                    <geoportal-page hide-sidebar-prop="true" endpoint-name="management-unit"></geoportal-page>
                </div>
            </div>
            @verbatim
                <div class="col-md-8" id="management-unit-grid">
                    <div class="mt-4" style="overflow-x: scroll">
                        <h5 class="text-center green-text mb-2">{{ translate('management_unit_title') }}</h5>
                        <div class="row">
                            <div class="col-sm-8 d-flex align-items-center">
                                <a class="btn btn-md" :href="createRoute()" v-permission="'management-unit.add'">
                                    <i class="fas fa-plus-circle"></i> {{ translate('add_management_unit') }}
                                </a>
                            </div>
                            <div class="md-form col-sm-4">
                                <div class="form-row justify-content-end" v-permission="'management-unit.view'">
                                    <div class="col-sm-10">
                                        <label for="company_name">{{ translate('search') }}</label>
                                        <input @keyup.enter="fetchData" class="form-control" v-model="search" type="text" Placeholder="" name="management_unit_name" id="management_unit_name" />
                                    </div>
                                    <button @click="fetchData" class="btn btn-sm btn-green  px-2" id="filter">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <grid v-permission="'management-unit.view'" :columns="grid.columns" :options="grid.options"></grid>
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
            Gabon.Pages.render('geoportalpage');
        });
    </script>
@endsection
