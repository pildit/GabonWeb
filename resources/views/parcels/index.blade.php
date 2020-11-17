@extends('layouts.app')

@section('title', 'Parcels')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-4">
      THE MAP
    </div>
    <div class="col-md-8">
      <div id="items-grid">
        @verbatim
        <h5 class="text-center green-text mb-2">{{translate('parcels_title')}}</h5>
        <div class="row">
          <div class="col-sm-8 d-flex align-items-center">
            <button class="btn btn-md" @click="modals.form = true">
              <i class="fas fa-plus-circle"></i> {{translate('add_parcels')}}
            </button>
          </div>
          <div class="md-form col-sm-4">
            <div class="form-row justify-content-end">
              <div class="col-sm-10">
                <label for="company_name">{{translate('Search')}}</label>
                <input @keyup.enter="fetchData" class="form-control" v-model="search" type="text" Placeholder="" name="parcels_name" id="parcels_name" />
              </div>
              <button @click="fetchData" class="btn btn-sm btn-green  px-2" id="filter">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>
        <grid :columns="grid.columns" :options="grid.options"></grid>
        @endverbatim
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
    Gabon.Base.getTranslations().then(() => {
        Gabon.Parcel.render('items-grid');
    });
</script>
@endsection