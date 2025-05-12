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
        <h2 class="text-xl font-semibold text-gray-800">
            <?php echo e(__('Головна')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    
    <div class="py-16 bg-gradient-to-br from-pink-50 to-pink-100">
        <div class="max-w-4xl mx-auto text-center px-4 space-y-6">
            <h1 class="text-5xl font-extrabold text-pink-700">
                Ласкаво просимо до нашого салону краси!
            </h1>
            <p class="text-xl text-gray-700">
                Ми робимо світ красивішим 💄✨<br>
                Запишіться до наших професіоналів та скористайтеся найкращими послугами вже сьогодні!
            </p>
        </div>
    </div>

    
    <div class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <h2 class="text-2xl font-bold text-gray-800">📰 Останні новини</h2>

            <?php $__empty_1 = true; $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-pink-50 p-6 rounded shadow-sm space-y-2">
                    <h3 class="text-xl font-semibold text-pink-700"><?php echo e($item->title); ?></h3>
                    <p class="text-sm text-gray-500"><?php echo e($item->published_at?->format('d.m.Y')); ?></p>
                    <p class="text-gray-700"><?php echo e(\Illuminate\Support\Str::limit($item->content, 200)); ?></p>
                    <a href="<?php echo e(route('news.show', $item)); ?>" class="text-pink-600 hover:underline">Читати далі →</a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-500">Новин поки немає.</p>
            <?php endif; ?>
        </div>
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
<?php /**PATH C:\xampp\htdocs\diplom-salon\resources\views/home.blade.php ENDPATH**/ ?>