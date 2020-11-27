@extends('layouts.app')

@section('title', @lang('product_types'))

@section('content')
<div id="product-types-grid">
    <product-types-grid v-permission="'product-types.view'"></product-types-grid>
</div>
@endsection

@section('scripts')
<script>
    Gabon.Base.getTranslations().then(() => {
        Gabon.ProductType.render('product-types-grid');
    });
</script>
@endsection
