<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/edit.css') }}">
    </head>
    <body>
        <form id="product-form" action="{{ route('update', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h1>商品情報編集画面</h1>
            <label for="id">ID</label><br>
            <input type="text" id="id" name="id" value="{{ $product->id }}" readonly><br>
            <label for="name">商品名</label><br>
            <input type="text" id="name" name="name" value="{{ $product->product_name }}"><br>
            <label for="company_id">メーカーID</label><br>
            <input type="text" id="company_id" name="company_id" value="{{ $product->company->id }}" readonly><br>
            <label for="manufacturer">メーカー名</label><br>
            <input type="text" id="manufacturer" name="manufacturer" value="{{ $product->company->company_name }}"><br>
            <label for="price">価格</label><br>
            <input type="number" id="price" name="price" value="{{ $product->price }}"><br>
            <label for="stock">在庫数</label><br>
            <input type="number" id="stock" name="stock" value="{{ $product->stock }}"><br>
            <label for="comment">コメント</label><br>
            <textarea id="comment" name="comment">{{ $product->comment }}</textarea><br>
            <label for="image">商品画像</label><br>
            <input type="file" id="image" name="image"><br>
            <input type="submit" value="更新">
            <button id="back-button">戻る</button>
        </form>
        <script src="{{ asset('js/edit.js') }}"></script>
    </body>
</html>
