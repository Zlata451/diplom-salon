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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Всі послуги
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6 max-w-7xl mx-auto">
        <?php if(session('success')): ?>
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="mb-4">
            <a href="<?php echo e(route('admin.services.create')); ?>" class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700">
                ➕ Додати послугу
            </a>
        </div>

        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">Назва</th>
                    <th class="px-4 py-2 text-left">Опис</th>
                    <th class="px-4 py-2 text-left">Ціна (грн)</th>
                    <th class="px-4 py-2 text-left">Тривалість (хв)</th>
                    <th class="px-4 py-2 text-left">Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2"><?php echo e($service->name); ?></td>
                        <td class="px-4 py-2"><?php echo e($service->description); ?></td>
                        <td class="px-4 py-2"><?php echo e($service->price); ?></td>
                        <td class="px-4 py-2"><?php echo e($service->duration); ?></td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="<?php echo e(route('admin.services.edit', $service->id)); ?>"
                               class="text-blue-600 hover:underline">Редагувати</a>

                            <form action="<?php echo e(route('admin.services.destroy', $service->id)); ?>" method="POST" class="inline"
                                  onsubmit="return confirm('Ви впевнені, що хочете видалити цю послугу?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:underline">Видалити</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">Поки що немає жодної послуги 😔</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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
<?php /**PATH C:\xampp\htdocs\diplom-salon\resources\views/admin/services/index.blade.php ENDPATH**/ ?>