@extends('layouts.app')

@section('title', 'Product List')

@section('content')
    <form id="search-form">
        <input type="text" id="search-input" placeholder="検索キーワード">
        <div class="form-group">
            <label for="manufacturer-select">メーカー名:</label>
            <select id="manufacturer-select" name="manufacturer">
                <option value="">メーカー名</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="price-range">価格範囲:</label>
            <input type="number" id="min-price" placeholder="下限">
            <input type="number" id="max-price" placeholder="上限">
        </div>
        <div class="form-group">
            <label for="stock-range">在庫数範囲:</label>
            <input type="number" id="min-stock" placeholder="下限">
            <input type="number" id="max-stock" placeholder="上限">
        </div>
        <button type="submit" id="search-button" onclick="searchProducts(event)">検索</button>
    </form>
    
    <div id="table-container">
        @include('table')
    </div>

    <!--<script src="{{ asset('js/jquery.min.js') }}"></script>-->
    <script src="{{ asset('js/list.js') }}"></script>
@endsection
