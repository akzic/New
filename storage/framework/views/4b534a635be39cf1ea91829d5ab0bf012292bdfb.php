<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/edit.css')); ?>">
    </head>
    <body>
        <form id="product-form" action="<?php echo e(route('update', ['id' => $product->id])); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <h1>商品情報編集画面</h1>
            <label for="id">ID</label><br>
            <input type="text" id="id" name="id" value="<?php echo e($product->id); ?>" readonly><br>
            <label for="name">商品名</label><br>
            <input type="text" id="name" name="name" value="<?php echo e($product->product_name); ?>"><br>
            <label for="company_id">メーカーID</label><br>
            <input type="text" id="company_id" name="company_id" value="<?php echo e($product->company->id); ?>" readonly><br>
            <label for="manufacturer">メーカー名</label><br>
            <input type="text" id="manufacturer" name="manufacturer" value="<?php echo e($product->company->company_name); ?>"><br>
            <label for="price">価格</label><br>
            <input type="number" id="price" name="price" value="<?php echo e($product->price); ?>"><br>
            <label for="stock">在庫数</label><br>
            <input type="number" id="stock" name="stock" value="<?php echo e($product->stock); ?>"><br>
            <label for="comment">コメント</label><br>
            <textarea id="comment" name="comment"><?php echo e($product->comment); ?></textarea><br>
            <label for="image">商品画像</label><br>
            <input type="file" id="image" name="image"><br>
            <input type="submit" value="更新">
            <button id="back-button">戻る</button>
        </form>
        <script src="<?php echo e(asset('js/edit.js')); ?>"></script>
    </body>
</html>
<?php /**PATH /Applications/MAMP/htdocs/New/resources/views/edit.blade.php ENDPATH**/ ?>