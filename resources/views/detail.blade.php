@extends('layouts.app')

@section('title', 'Product Detail')

@section('content')
        <h1>商品情報詳細画面</h1>

        <div>
            <label>ID</label>
            <span>{{ $product->id }}</span>
        </div>

        <div>
            <label>商品画像</label>
            <span>{{ $product->img_path }}</span>
        </div>

        <div>
            <label>商品名</label>
            <span>{{ $product->product_name }}</span>
        </div>

        <div>
            <label>メーカー</label>
            <span>{{ $product->company->company_name }}</span>
        </div>

        <div>
            <label>価格</label>
            <span>{{ $product->price }}</span>
        </div>

        <div>
            <label>在庫数</label>
            <span>{{ $product->stock }}</span>
        </div>

        <div>
            <label>コメント</label>
            <span>{{ $product->comment }}</span>
        </div>

        <button onclick="edit('{{ $product->id }}')">編集</button>
        <button onclick="goBack()">戻る</button>

        <script  src="{{asset('js/detail.js')}}"></script>
@endsection
