<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="text-xl font-semibold text-gray-800">Додати новину</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6 max-w-4xl mx-auto">
        <form action="<?php echo e(route('admin.news.store')); ?>" method="POST" class="bg-white p-6 rounded shadow space-y-4">
            <?php echo csrf_field(); ?>

            <div>
                <label for="title" class="block font-medium">Заголовок</label>
                <input type="text" id="title" name="title" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label for="type" class="block font-medium">Тип</label>
                <select name="type" id="type" class="w-full border rounded p-2">
                    <option value="новина">Новина</option>
                    <option value="акція">Акція</option>
                    <option value="новинка">Новинка</option>
                </select>
            </div>

            <div>
                <label for="content" class="block font-medium">Текст</label>
                <textarea name="content" id="content" rows="5" class="w-full border rounded p-2" required></textarea>
            </div>

            <div>
                <label for="published_at" class="block font-medium">Дата публікації</label>
                <input type="date" name="published_at" id="published_at" class="w-full border rounded p-2">
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    💾 Зберегти
                </button>
            </div>
        </form>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\diplom-salon\resources\views/admin/news/create.blade.php ENDPATH**/ ?>