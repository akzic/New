@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
        <h1>商品新規登録画面</h1>

        <form id="product-form" action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 商品名 -->
            <div class="form-group">
                <label for="product-name">商品名:</label>
                <input type="text" id="product-name" name="product-name" required placeholder="商品名を入力してください" value="{{ old('product-name') }}">
                @if ($errors->has('product-name'))
                    <div class="error-message">{{ $errors->first('product-name') }}</div>
                @endif
            </div>

            <!-- メーカー名 -->
            <div class="form-group">
                <label for="company-name">メーカー名:</label>
                <input type="text" id="company-name" name="manufacturer" required placeholder="メーカー名を入力してください" value="{{ old('manufacturer') }}">
                @if ($errors->has('manufacturer'))
                    <div class="error-message">{{ $errors->first('manufacturer') }}</div>
                @endif
            </div>

            <!-- 価格 -->
            <div class="form-group">
                <label for="price">価格:</label>
                <input type="number" id="price" name="price" required placeholder="価格を入力してください" value="{{ old('price') }}">
                @if ($errors->has('price'))
                    <div class="error-message">{{ $errors->first('price') }}</div>
                @endif
            </div>

            <!-- 在庫数 -->
            <div class="form-group">
                <label for="stock">在庫数:</label>
                <input type="number" id="stock" name="stock" required placeholder="在庫数を入力してください" value="{{ old('stock') }}">
                @if ($errors->has('stock'))
                    <div class="error-message">{{ $errors->first('stock') }}</div>
                @endif
            </div>

            <!-- コメント -->
            <div class="form-group">
                <label for="comment">コメント:</label><br>
                <textarea id="comment" name="comment" rows="4" cols="50" placeholder="コメントを入力してください">{{ old('comment') }}</textarea>
                @if ($errors->has('comment'))
                    <div class="error-message">{{ $errors->first('comment') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="product-image">商品画像:</label>
                <input type="file" id="product-image" name="product-image" accept="image/*">
            </div>

            <input type="submit" value="新規登録">
            <input type="button" value="戻る" onclick="history.back()">
        </form>

        <script src="{{ asset('js/add.js') }}"></script>
@endsection
