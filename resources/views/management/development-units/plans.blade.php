@extends('layouts.app')

@section('title', @lang('development_plans'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            @verbatim
                <div class="col-md-12" id="development-unit-plans">
                    <div class="mt-4" >
                        <h5 class="text-center green-text mb-2">{{ translate('development_plans_title') }}</h5>
                        <div class="row">
                            <div class="col-sm-8 d-flex align-items-center"></div>
                            <div class="md-form col-sm-4">
                                <div class="form-row justify-content-end" v-permission="'development-unit.view'">
                                    <div class="col">
                                        <label for="development_plan_name">{{ translate('search') }}</label>
                                        <input @keyup.enter="fetchData" class="form-control" v-model="search" type="text" Placeholder="" name="development_plan_name" id="development_plan_name" />
                                    </div>
                                    <button @click="fetchData" class="btn btn-sm btn-green  px-2" id="filter">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <grid v-permission="'development-unit.view'" :columns="grid.columns" :options="grid.options"></grid>
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
            Gabon.Management.DevelopmentPlan.render('development-unit-plans', {
                id : {{$id}}
            });
        });
    </script>
@endsection
