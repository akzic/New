<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>商品新規登録画面</title>
        <link href="<?php echo e(asset('css/add.css')); ?>" rel="stylesheet">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    </head>
    <body>
        <h1>商品新規登録画面</h1>

        <form id="product-form" action="<?php echo e(route('store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="product-name">商品名:</label>
                <input type="text" id="product-name" name="product-name" required>
            </div>

            <div class="form-group">
                <label for="company-name">メーカー名:</label>
                <input type="text" id="company-name" name="manufacturer" required>
            </div>

            <div class="form-group">
                <label for="price">価格:</label>
                <input type="number" id="price" name="price" required>
            </div>

            <div class="form-group">
                <label for="stock">在庫数:</label>
                <input type="number" id="stock" name="stock" required>
            </div>

            <div class="form-group">
                <label for="comment">コメント:</label><br>
                <textarea id="comment" name="comment" rows="4" cols="50"></textarea>
            </div>

            <div class="form-group">
                <label for="product-image">商品画像:</label>
                <input type="file" id="product-image" name="product-image" accept="image/*">
            </div>

            <input type="submit" value="新規登録">
            <input type="button" value="戻る" onclick="history.back()">
        </form>

        <script src="<?php echo e(asset('js/add.js')); ?>"></script>
    </body>
</html>
<?php /**PATH /Applications/MAMP/htdocs/New/resources/views/add.blade.php ENDPATH**/ ?>