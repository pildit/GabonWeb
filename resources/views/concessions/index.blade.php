@extends('layouts.app')

@section('title', @lang('concessions'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div id="geoportalpage" class="col-md-4" style="position: fixed; padding: 10px">
                    <geoportal-page hide-sidebar-prop="true" endpoint-name="concessions"></geoportal-page>
                </div>
            </div>
            <div class="col-md-8">
                <div id="concessions-grid" v-permission="'concession.view'" >
                    @verbatim
                        <h5 class="text-center green-text mb-2">{{translate('concessions_title')}}</h5>
                        <div class="row">
                            <div class="col-sm-6 d-flex align-items-center">
                                <a class="btn btn-md" :href="createRoute()" v-permission="'concession.add'">
                                    <i class="fas fa-plus-circle"></i> {{translate('add_concessions')}}
                                </a>
                            </div>
                            <div class="md-form col-sm-6">
                                <div class="form-row justify-content-end" v-permission="'concession.view'">
                                    <div class="col-sm-10">
                                        <label for="company_name">{{translate('Search')}}</label>
                                        <input @keyup.enter="fetchData" class="form-control" v-model="search" type="text" Placeholder="" name="concessions_name" id="concessions_name" />
                                    </div>
                                    <button @click="fetchData" class="btn btn-sm btn-green  px-2" id="filter">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <grid v-permission="'concession.view'" :columns="grid.columns" :options="grid.options"></grid>
                    @endverbatim
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Concession.render('concessions-grid');
            Gabon.Pages.render('geoportalpage');
        });
    </script>
@endsection
