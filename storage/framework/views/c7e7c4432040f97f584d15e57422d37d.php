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
           ✏️ Редагувати майстра
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6 px-4 max-w-2xl mx-auto">
        <?php if($errors->any()): ?>
            <div class="mb-4 text-red-600">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>• <?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.masters.update', $master->id)); ?>" method="POST" enctype="multipart/form-data" class="space-y-5">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div>
                <label for="name" class="block font-medium">Ім’я майстра:</label>
                <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2"
                       value="<?php echo e(old('name', $master->name)); ?>" required>
            </div>

            <div>
                <label for="specialty" class="block font-medium">Спеціалізація:</label>
                <input type="text" name="specialty" id="specialty" class="w-full border rounded px-3 py-2"
                       value="<?php echo e(old('specialty', $master->specialty)); ?>" required>
            </div>

            <div>
                <label for="phone" class="block font-medium">Телефон:</label>
                <input type="text" name="phone" id="phone" class="w-full border rounded px-3 py-2"
                       value="<?php echo e(old('phone', $master->phone)); ?>">
            </div>

            <div>
                <label for="email" class="block font-medium">Email:</label>
                <input type="email" name="email" id="email" class="w-full border rounded px-3 py-2"
                       value="<?php echo e(old('email', $master->email)); ?>">
            </div>

            <div>
                <label class="block font-medium">Фото майстра:</label>
                <?php if($master->photo): ?>
                    <div class="mb-2">
                        <img src="<?php echo e(asset('storage/' . $master->photo)); ?>" alt="Фото майстра" class="h-32 rounded shadow">
                    </div>
                <?php endif; ?>
                <input type="file" name="photo" class="w-full">
                <p class="text-sm text-gray-500 mt-1">Завантаж нове фото, щоб замінити наявне (необов’язково).</p>
            </div>

            <div>
                <label class="block font-medium mb-2">Послуги майстра:</label>
                <div class="grid grid-cols-2 gap-2">
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="services[]" value="<?php echo e($service->id); ?>"
                                   <?php if($master->services->contains($service->id)): echo 'checked'; endif; ?>>
                            <span><?php echo e($service->name); ?></span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <hr class="my-6">

            <h3 class="font-semibold text-lg text-gray-700">🗓️ Графік роботи</h3>

            <?php $__currentLoopData = [
                'monday' => 'Понеділок',
                'tuesday' => 'Вівторок',
                'wednesday' => 'Середа',
                'thursday' => 'Четвер',
                'friday' => 'Пʼятниця',
                'saturday' => 'Субота',
                'sunday' => 'Неділя'
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $hours = $master->workingHours->firstWhere('day_of_week', $day);
                    $start = old("working_hours.$day.start_time", $hours?->start_time ? \Illuminate\Support\Str::limit($hours->start_time, 5, '') : null);
                    $end = old("working_hours.$day.end_time", $hours?->end_time ? \Illuminate\Support\Str::limit($hours->end_time, 5, '') : null);
                    $isDayOff = $start === null || $end === null;
                ?>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 mb-1"><?php echo e($label); ?></label>
                    <div class="flex items-center gap-4">
                        <input type="time" name="working_hours[<?php echo e($day); ?>][start_time]"
                               value="<?php echo e($start); ?>"
                               class="border rounded px-3 py-1">

                        <span>—</span>

                        <input type="time" name="working_hours[<?php echo e($day); ?>][end_time]"
                               value="<?php echo e($end); ?>"
                               class="border rounded px-3 py-1">

                        <label class="flex items-center space-x-2 ml-4">
                            <input type="hidden" name="working_hours[<?php echo e($day); ?>][day_off]" value="0">
                            <input type="checkbox" name="working_hours[<?php echo e($day); ?>][day_off]" value="1"
                                   <?php echo e($isDayOff ? 'checked' : ''); ?>

                                   onchange="this.closest('div').querySelectorAll('input[type=time]').forEach(el => {
                                       if (this.checked) {
                                           el.value = '';
                                       }
                                   })">
                            <span>Вихідний</span>
                        </label>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="pt-6">
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    💾 Зберегти зміни
                </button>
                <a href="<?php echo e(route('admin.masters.index')); ?>" class="ml-3 text-blue-500 hover:underline">⬅ Назад</a>
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
<?php /**PATH C:\xampp\htdocs\diplom-salon\resources\views/admin/masters/edit.blade.php ENDPATH**/ ?>