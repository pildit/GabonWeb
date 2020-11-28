@extends('layouts.app')

@section('title', @lang('development_unit'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div id="geoportalpage" class="col-md-4" style="position: fixed; padding: 10px">
                    <geoportal-page hide-sidebar-prop="true" endpoint-name="development-unit"></geoportal-page>
                </div>
            </div>
            @verbatim
            <div class="col-md-8" id="development-unit-grid">
                <div class="mt-4" style="overflow-x: scroll">
                    <h5 class="text-center green-text mb-2">{{ translate('development_unit_title') }}</h5>
                    <div class="row">
                        <div class="col-sm-6 d-flex align-items-center">
                            <a class="btn btn-md" :href="createRoute()" v-permission="'development-unit.add'">
                                <i class="fas fa-plus-circle"></i> {{ translate('add_development_unit') }}
                            </a>
                        </div>
                        <div class="md-form col-sm-6">
                            <div class="form-row justify-content-end" v-permission="'development-unit.view'">
                                <div class="col text-right pt-2">
                                    <date-range-picker
                                        opens="center"
                                        ref="picker"
                                        :singleDatePicker="false"
                                        v-model="dateRange"
                                        :linkedCalendars="true"
                                        @update="updateDates"
                                    >
                                        <template v-slot:input="picker" style="min-width: 350px;">
                                            {{ picker.startDate | date(translate('start_date')) }} - {{ picker.endDate | date(translate('end_date'))}}
                                        </template>
                                    </date-range-picker>
                                </div>
                                <div class="col">
                                    <label for="company_name">{{ translate('search') }}</label>
                                    <input @keyup.enter="fetchData" class="form-control" v-model="search" type="text" Placeholder="" name="development_unit_name" id="development_unit_name" />
                                </div>
                                <button @click="fetchData" class="btn btn-sm btn-green  px-2" id="filter">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <grid v-permission="'development-unit.view'" :columns="grid.columns" :options="grid.options"></grid>
                    <button class="btn btn-outline-info btn-sm" @click.prevent="exportXLS" :disabled="exportLoading">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="exportLoading"></span>
                        Export.xls
                    </button>
                </div>
            </div>
            @endverbatim
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Management.DevelopmentUnit.render('development-unit-grid');
            Gabon.Pages.render('geoportalpage');
        });
    </script>
@endsection
