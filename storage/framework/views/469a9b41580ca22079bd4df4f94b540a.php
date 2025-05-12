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
            📋 Список майстрів
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6 px-4 max-w-6xl mx-auto">
        <?php if(session('success')): ?>
            <div class="mb-4 text-green-700 bg-green-100 border-l-4 border-green-500 p-4 rounded shadow">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="mb-4 flex justify-end">
            <a href="<?php echo e(route('admin.masters.create')); ?>"
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                ➕ Додати майстра
            </a>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <table class="w-full table-auto border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">Ім’я</th>
                        <th class="border px-4 py-2">Спеціалізація</th>
                        <th class="border px-4 py-2">Телефон</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Графік роботи</th>
                        <th class="border px-4 py-2">Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $masters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $master): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo e($master->name); ?></td>
                            <td class="border px-4 py-2"><?php echo e($master->specialty); ?></td>
                            <td class="border px-4 py-2"><?php echo e($master->phone ?? '—'); ?></td>
                            <td class="border px-4 py-2"><?php echo e($master->email ?? '—'); ?></td>
                            <td class="border px-4 py-2 text-sm leading-snug">
                                <?php
                                    $daysUa = [
                                        'monday' => 'Пн',
                                        'tuesday' => 'Вт',
                                        'wednesday' => 'Ср',
                                        'thursday' => 'Чт',
                                        'friday' => 'Пт',
                                        'saturday' => 'Сб',
                                        'sunday' => 'Нд',
                                    ];
                                ?>
                                <?php $__empty_2 = true; $__currentLoopData = $master->workingHours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wh): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                    <div>
                                        <strong><?php echo e($daysUa[$wh->day_of_week] ?? $wh->day_of_week); ?>:</strong>
                                        <?php echo e(\Carbon\Carbon::parse($wh->start_time)->format('H:i')); ?>

                                        —
                                        <?php echo e(\Carbon\Carbon::parse($wh->end_time)->format('H:i')); ?>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                    <span class="text-gray-400 italic">немає даних</span>
                                <?php endif; ?>
                            </td>
                            <td class="border px-4 py-2 space-y-2 text-center">
                                <a href="<?php echo e(route('admin.masters.edit', $master->id)); ?>"
                                   class="text-blue-600 hover:underline block">✏️ Редагувати</a>

                                <form action="<?php echo e(route('admin.masters.destroy', $master->id)); ?>"
                                      method="POST" onsubmit="return confirm('Ви впевнені, що хочете видалити цього майстра?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:underline block">
                                        🗑️ Видалити
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">Майстрів поки немає.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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
<?php /**PATH C:\xampp\htdocs\diplom-salon\resources\views/admin/masters/index.blade.php ENDPATH**/ ?>