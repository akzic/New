@extends('layouts.app')

@section('title', 'Product List')

@section('content')
        <form>
            <input type = "text" id = "search-input" placeholder = "検索キーワード">
            <select id = "manufacturer-select">
                <option value = "">メーカー名</option>
            </select>
            <button type = "button" onclick = "searchProducts()">検索</button>
        </form>
        <div class="links">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>商品画像</th>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th>メーカー名</th>
                        <th>
                            <button onclick = "addProduct()">新規登録</button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($products ?? [] as $product)
                    <tr>
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
                            <form action="{{ route('product.destroy', ['id' => $product->id]) }}" method="POST" onsubmit="return confirm('削除してもよろしいですか？')">
                                @csrf
                                @method('DELETE')
                                <button type="submit">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <script  src="{{asset('js/list.js')}}"></script>
@endsection
