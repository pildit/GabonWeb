@extends('layouts.app')

@section('title', @lang('constituent_permits'))

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-4">
      <div id="geoportalpage" class="col-md-4" style="position: fixed; padding: 10px">
        <geoportal-page hide-sidebar-prop="true" endpoint-name="constituent-permit"></geoportal-page>
      </div>
    </div>
    <div class="col-md-8">
      <div id="items-grid" v-permission="'constituent-permit.view'" style="overflow-x: scroll">
        @verbatim
        <h5 class="text-center green-text mb-2">{{ translate('constituent_permit_title') }}</h5>
        <div class="row">
          <div class="col-sm-8 d-flex align-items-center">
            <a class="btn btn-md" :href="createRoute()" v-permission="'constituent-permit.add'">
              <i class="fas fa-plus-circle"></i> {{translate('add_constituent_permit')}}
            </a>
          </div>
          <div class="md-form col-sm-4">
            <div class="form-row justify-content-end">
              <div class="col-sm-10">
                <label for="company_name">{{ translate('search') }}</label>
                <input @keyup.enter="fetchData" class="form-control" v-model="search" type="text" Placeholder="" name="constituent_permit_name" id="constituent_permit_name" />
              </div>
              <button @click="fetchData" class="btn btn-sm btn-green  px-2" id="filter">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>
        <grid :columns="grid.columns" :options="grid.options" v-permission="'constituent-permit.add'"></grid>
        @endverbatim
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
    Gabon.Base.getTranslations().then(() => {
        Gabon.ConstituentPermit.render('items-grid');
        Gabon.Pages.render('geoportalpage');
    });
</script>
@endsection
