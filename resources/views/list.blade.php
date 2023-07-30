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
        <button type="button" id="search-button" onclick="searchProducts(event)">検索</button>
    </form>
    
    <div class="links">
        <table>
            <thead>
            <tr>
                <th><a href="#" onclick="sortProductsByField('id')">ID</a></th>
                <th>商品画像</th>
                <th><a href="#" onclick="sortProductsByField('product_name')">商品名</a></th>
                <th><a href="#" onclick="sortProductsByField('price')">価格</a></th>
                <th><a href="#" onclick="sortProductsByField('stock')">在庫数</a></th>
                <th><a href="#" onclick="sortProductsByField('company_name')">メーカー名</a></th>
                <th>
                    <button onclick="addProduct()">新規登録</button>
                </th>
            </tr>
            </thead>
            <tbody id="product-list">
                @foreach ($products ?? [] as $product)
                    <tr id="product-row-{{ $product->id }}">
                        <td>{{ $product->id }}</td>
                        <td><img src="{{ asset('storage/images/' . $product->img_path) }}" alt="商品画像"></td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->company->company_name }}</td>
                        <td>
                            <button onclick="showDetail('{{ $product->id }}')">詳細</button>
                        </td>
                        <td>
                            <button type="button" onclick="deleteProduct(event, {{ $product->id }})">削除</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!--<script src="{{ asset('js/jquery.min.js') }}"></script>-->
    <script src="{{ asset('js/list.js') }}"></script>
@endsection
