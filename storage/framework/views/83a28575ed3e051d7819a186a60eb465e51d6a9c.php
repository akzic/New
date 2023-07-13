<!DOCTYPE html>
<html >
    <head>
        <meta charset="utf-8">

        <title>商品一覧画面</title>

        <link href="<?php echo e(asset('css/list.css')); ?>" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    </head>
    <body class="linkbody">
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
                <?php $__currentLoopData = $products ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($product->id); ?></td>
                        <td><img src="<?php echo e(asset('storage/images/' . $product->img_path)); ?>" alt="商品画像"></td>
                        <td><?php echo e($product->product_name); ?></td>
                        <td><?php echo e($product->price); ?></td>
                        <td><?php echo e($product->stock); ?></td>
                        <td><?php echo e($product->company->company_name); ?></td>
                        <td>
                            <button onclick="showDetail('<?php echo e($product->id); ?>')">詳細</button>
                        </td>
                        <td>
                            <form action="<?php echo e(route('product.destroy', ['id' => $product->id])); ?>" method="POST" onsubmit="return confirm('削除してもよろしいですか？')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit">削除</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <script  src="<?php echo e(asset('js/list.js')); ?>"></script>
    </body>
</html>
<?php /**PATH /Applications/MAMP/htdocs/New/resources/views/list.blade.php ENDPATH**/ ?>