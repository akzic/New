<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>商品情報詳細画面</title>
        <link href="<?php echo e(asset('css/detail.css')); ?>" rel="stylesheet">
    </head>
    <body class = detailbody>
        <h1>商品情報詳細画面</h1>

        <div>
            <label>ID</label>
            <span><?php echo e($product->id); ?></span>
        </div>

        <div>
            <label>商品画像</label>
            <span><?php echo e($product->img_path); ?></span>
        </div>

        <div>
            <label>商品名</label>
            <span><?php echo e($product->product_name); ?></span>
        </div>

        <div>
            <label>メーカー</label>
            <span><?php echo e($product->company->company_name); ?></span>
        </div>

        <div>
            <label>価格</label>
            <span><?php echo e($product->price); ?></span>
        </div>

        <div>
            <label>在庫数</label>
            <span><?php echo e($product->stock); ?></span>
        </div>

        <div>
            <label>コメント</label>
            <span><?php echo e($product->comment); ?></span>
        </div>

        <button onclick="edit('<?php echo e($product->id); ?>')">編集</button>
        <button onclick="goBack()">戻る</button>

        <script  src="<?php echo e(asset('js/detail.js')); ?>"></script>
    </body>
</html>
<?php /**PATH /Applications/MAMP/htdocs/New/resources/views/detail.blade.php ENDPATH**/ ?>