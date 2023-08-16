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
