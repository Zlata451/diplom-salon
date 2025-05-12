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
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            <?php echo e(__('Мої записи')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <?php if(session('success')): ?>
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded shadow">
                    <ul class="list-disc list-inside text-sm">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>• <?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            
            <form method="GET" action="<?php echo e(route('appointments.my')); ?>" class="mb-6 flex items-center gap-4">
                <label for="status" class="font-medium text-sm text-gray-700">Фільтрувати за статусом:</label>
                <select name="status" id="status" onchange="this.form.submit()"
                        class="rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">
                    <option value="">— Всі —</option>
                    <option value="заплановано" <?php echo e(request('status') === 'заплановано' ? 'selected' : ''); ?>>📅 Заплановано</option>
                    <option value="завершено" <?php echo e(request('status') === 'завершено' ? 'selected' : ''); ?>>✅ Завершено</option>
                    <option value="скасовано" <?php echo e(request('status') === 'скасовано' ? 'selected' : ''); ?>>❌ Скасовано</option>
                </select>
            </form>

            <div class="overflow-x-auto bg-white p-6 shadow-sm sm:rounded-lg">
                <table class="min-w-full table-auto border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">Послуга</th>
                            <th class="border px-4 py-2">Майстер</th>
                            <th class="border px-4 py-2">Дата</th>
                            <th class="border px-4 py-2">Час</th>
                            <th class="border px-4 py-2">Статус</th>
                            <th class="border px-4 py-2">Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="border px-4 py-2"><?php echo e($appointment->service->name); ?></td>
                                <td class="border px-4 py-2"><?php echo e($appointment->master->name); ?></td>
                                <td class="border px-4 py-2"><?php echo e($appointment->date); ?></td>
                                <td class="border px-4 py-2"><?php echo e($appointment->time); ?></td>
                                <td class="border px-4 py-2">
                                    <?php if($appointment->status === 'заплановано'): ?>
                                        📅 Заплановано
                                    <?php elseif($appointment->status === 'завершено'): ?>
                                        ✅ Завершено
                                    <?php else: ?>
                                        ❌ Скасовано
                                    <?php endif; ?>
                                </td>
                                <td class="border px-4 py-2 text-center space-y-1">
                                    
                                    <?php if(in_array($appointment->status, ['завершено', 'скасовано'])): ?>
                                        <a href="<?php echo e(route('appointments.bookWithMaster', $appointment->master->id)); ?>?service_id=<?php echo e($appointment->service->id); ?>"
                                           class="inline-block text-blue-600 hover:underline text-sm">
                                            🔁 Повторити запис
                                        </a>
                                    <?php endif; ?>

                                    
                                    <?php if($appointment->status === 'заплановано'): ?>
                                        <form action="<?php echo e(route('appointments.cancel', $appointment)); ?>" method="POST"
                                              onsubmit="return confirm('Ви впевнені, що хочете скасувати цей запис?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit"
                                                    class="text-red-600 hover:underline text-sm">
                                                Скасувати
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-gray-500 py-4">Записів поки що немає.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
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
<?php /**PATH C:\xampp\htdocs\diplom-salon\resources\views/appointments/my.blade.php ENDPATH**/ ?>