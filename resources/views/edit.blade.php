@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
        <form id="product-form" action="{{ route('update', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h1>商品情報編集画面</h1>
            <!-- 商品名 -->
            <label for="name">商品名</label><br>
            <input type="text" id="name" name="name" placeholder="商品名を入力してください" value="{{ old('name', $product->product_name) }}"><br>
            @if ($errors->has('name'))
                <div class="error-message">{{ $errors->first('name') }}</div>
            @endif

            <!-- メーカー名 -->
            <label for="manufacturer">メーカー名</label><br>
            <select id="manufacturer" name="manufacturer" required>
                <option value="" disabled>メーカー名を選択してください</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" @if($company->id == $product->company->id) selected @endif>{{ $company->company_name }}</option>
                @endforeach
            </select><br>
            @if ($errors->has('manufacturer'))
                <div class="error-message">{{ $errors->first('manufacturer') }}</div>
            @endif

            <!-- 価格 -->
            <label for="price">価格</label><br>
            <input type="number" id="price" name="price" placeholder="価格を入力してください" value="{{ old('price', $product->price) }}"><br>
            @if ($errors->has('price'))
                <div class="error-message">{{ $errors->first('price') }}</div>
            @endif

            <!-- 在庫数 -->
            <label for="stock">在庫数</label><br>
            <input type="number" id="stock" name="stock" placeholder="在庫数を入力してください" value="{{ old('stock', $product->stock) }}"><br>
            @if ($errors->has('stock'))
                <div class="error-message">{{ $errors->first('stock') }}</div>
            @endif

            <!-- コメント -->
            <label for="comment">コメント</label><br>
            <textarea id="comment" name="comment" placeholder="コメントを入力してください">{{ old('comment', $product->comment) }}</textarea><br>
            @if ($errors->has('comment'))
                <div class="error-message">{{ $errors->first('comment') }}</div>
            @endif
            <label for="image">商品画像</label><br>
            <input type="file" id="image" name="image"><br>
            <input type="submit" value="更新">
            <button id="back-button">戻る</button>
        </form>
        <script src="{{ asset('js/edit.js') }}"></script>
@endsection
