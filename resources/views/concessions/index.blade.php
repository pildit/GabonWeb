@extends('layouts.app')

@section('title', @lang('concessions'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                {{lang('the_map')}}
            </div>
            <div class="col-md-8">
                <div id="concessions-grid">
                    @verbatim
                        <h5 class="text-center green-text mb-2">{{translate('concessions_title')}}</h5>
                        <div class="row">
                            <div class="col-sm-8 d-flex align-items-center">
                                <a class="btn btn-md" :href="createRoute()" v-permissions="'concession.add'">
                                    <i class="fas fa-plus-circle"></i> {{translate('add_concessions')}}
                                </a>
                            </div>
                            <div class="md-form col-sm-4">
                                <div class="form-row justify-content-end" v-permissions="'concession.view'">
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
                        <grid v-permissions="'concession.view'" :columns="grid.columns" :options="grid.options"></grid>
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
        });
    </script>
@endsection
