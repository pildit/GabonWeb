@extends('layouts.app')

@section('title', @lang('aac'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div id="geoportalpage" class="col-md-4" style="position: fixed; padding: 10px">
                    <geoportal-page hide-sidebar-prop="true" endpoint-name="aac-grid"></geoportal-page>
                </div>
            </div>
            @verbatim
                <div class="col-md-8" id="aac-grid">
                    <div class="mt-4">
                        <h5 class="text-center green-text mb-2">{{ translate('aac_title') }}</h5>
                        <div class="row">
                            <div class="col-sm-8 d-flex align-items-center">
                                <a class="btn btn-md" :href="createRoute()" v-permission="'AAC.add'">
                                    <i class="fas fa-plus-circle"></i> {{ translate('add_aac') }}
                                </a>
                            </div>
                            <div class="md-form col-sm-4">
                                <div class="form-row justify-content-end" v-permission="'AAC.view'">
                                    <div class="col-sm-10">
                                        <label for="company_name">{{ translate('search') }}</label>
                                        <input @keyup.enter="fetchData" class="form-control" v-model="search" type="text" Placeholder="" name="aac_name" id="aac_name" />
                                    </div>
                                    <button @click="fetchData" class="btn btn-sm btn-green  px-2" id="filter">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <grid v-permission="'AAC.view'" :columns="grid.columns" :options="grid.options"></grid>
                    </div>
                </div>
            @endverbatim
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Management.AAC.render('aac-grid');
            Gabon.Pages.render('geoportalpage');
        });
    </script>
@endsection
