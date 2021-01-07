@extends('layouts.app')

@section('title', @lang('management_plans'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            @verbatim
                <div class="col-md-12" id="management-unit-plans">
                    <div class="mt-4" >
                        <h5 class="text-center green-text mb-2">{{ translate('management_plans_title') }}</h5>
                        <div class="row">
                            <div class="col-sm-8 d-flex align-items-center"></div>
                            <div class="md-form col-sm-4">
                                <div class="form-row justify-content-end" v-permission="'management-unit.view'">
                                    <div class="col">
                                        <label for="management_plan_name">{{ translate('search') }}</label>
                                        <input @keyup.enter="fetchData" class="form-control" v-model="search" type="text" Placeholder="" name="management_plan_name" id="management_plan_name" />
                                    </div>
                                    <button @click="fetchData" class="btn btn-sm btn-green  px-2" id="filter">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <grid v-permission="'management-unit.view'" :columns="grid.columns" :options="grid.options"></grid>
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
            Gabon.Management.ManagementPlan.render('management-unit-plans', {
                id : {{$id}}
            });
        });
    </script>
@endsection
