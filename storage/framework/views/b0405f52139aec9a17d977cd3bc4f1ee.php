
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Inventory Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #DAB49D; color: #5E3023; }
        .card { border: 0; border-radius: 12px; }
        .btn-primary { background: #800776; border-color: #800776; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 700px;">
        <div class="card-body p-4">
            <h2 class="mb-4">Edit Inventory Product</h2>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('inventory.products.update', $product->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-3">
                    <label class="form-label" for="name">Product Name</label>
                    <input class="form-control" id="name" name="name"
                           value="<?php echo e(old('name', $product->name)); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="sku">SKU</label>
                    <input class="form-control" id="sku" name="sku"
                           value="<?php echo e(old('sku', $product->sku)); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="category">Category</label>
                    <input class="form-control" id="category" name="category"
                           value="<?php echo e(old('category', $product->category)); ?>">
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity"
                               name="quantity" min="0"
                               value="<?php echo e(old('quantity', $product->quantity)); ?>" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="reorder_level">Reorder Level</label>
                        <input type="number" class="form-control" id="reorder_level"
                               name="reorder_level" min="0"
                               value="<?php echo e(old('reorder_level', $product->reorder_level)); ?>" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="unit_price">Unit Price</label>
                        <input type="number" class="form-control" id="unit_price"
                               name="unit_price" min="0" step="0.01"
                               value="<?php echo e(old('unit_price', $product->unit_price)); ?>" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo e(route('inventory.index')); ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\xampp1\htdocs\laboratory06_2411600350\resources\views/inventory/edit.blade.php ENDPATH**/ ?>