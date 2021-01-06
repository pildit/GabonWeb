@extends('layouts.app')

@section('title', @lang('site_logbook_items'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            @verbatim
                <div class="col-md-12" id="site-logbook-item-grid">
                    <div class="mt-4" >
                        <h5 class="text-center green-text mb-2">{{ translate('site_logbook_items_title') }}</h5>
                        <div class="row">
                            <div class="col-sm-8 d-flex align-items-center"></div>
                            <div class="md-form col-sm-4">
                                <div class="form-row justify-content-end" v-permission="'site_logbook.view'">
                                    <div class="col">
                                        <label for="site_logbook_item_name">{{ translate('search') }}</label>
                                        <input @keyup.enter="fetchData" class="form-control" v-model="search" type="text" Placeholder="" name="site_logbook_item_name" id="site_logbook_item_name" />
                                    </div>
                                    <button @click="fetchData" class="btn btn-sm btn-green  px-2" id="filter">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <grid v-permission="'site_logbook.view'" :columns="grid.columns" :options="grid.options"></grid>
                            </div>
                        </div>
                    </div>
                </div>
            @endverbatim
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.SiteLogbookItem.render('site-logbook-item-grid', {
                id : {{$id}}
            });
        });
    </script>
@endsection
