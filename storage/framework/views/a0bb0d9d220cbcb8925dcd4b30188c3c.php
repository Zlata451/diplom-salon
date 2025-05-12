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
            Додати майстра
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6 px-4 max-w-3xl mx-auto">
        <?php if($errors->any()): ?>
            <div class="mb-4 text-red-600 bg-red-100 border-l-4 border-red-500 p-4 rounded">
                <ul class="list-disc list-inside text-sm">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>• <?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.masters.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-5 bg-white p-6 rounded shadow">
            <?php echo csrf_field(); ?>

            <div>
                <label for="name" class="block font-medium text-sm text-gray-700">Ім’я майстра:</label>
                <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label for="specialty" class="block font-medium text-sm text-gray-700">Спеціалізація:</label>
                <input type="text" name="specialty" id="specialty" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label for="phone" class="block font-medium text-sm text-gray-700">Телефон:</label>
                <input type="text" name="phone" id="phone" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label for="email" class="block font-medium text-sm text-gray-700">Email:</label>
                <input type="email" name="email" id="email" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label for="photo" class="block font-medium text-sm text-gray-700">Фото:</label>
                <input type="file" name="photo" id="photo" accept="image/*" class="w-full mt-1">
            </div>

            <!-- 📋 Послуги майстра -->
            <div>
                <label class="block font-medium text-sm text-gray-700 mb-2">Послуги майстра:</label>
                <div class="grid grid-cols-2 gap-2">
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center space-x-2">
                            <input
                                type="checkbox"
                                name="services[]"
                                value="<?php echo e($service->id); ?>"
                                <?php echo e(in_array($service->id, old('services', [])) ? 'checked' : ''); ?>

                            >
                            <span><?php echo e($service->name); ?></span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- 🕒 Графік роботи -->
            <div>
                <label class="block font-medium text-sm text-gray-700 mb-2">Графік роботи:</label>
                <?php $__currentLoopData = [
                    'monday' => 'Понеділок',
                    'tuesday' => 'Вівторок',
                    'wednesday' => 'Середа',
                    'thursday' => 'Четвер',
                    'friday' => 'Пʼятниця',
                    'saturday' => 'Субота',
                    'sunday' => 'Неділя'
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mb-2 flex items-center gap-4">
                        <label class="w-24"><?php echo e($label); ?>:</label>
                        <input type="time" name="working_hours[<?php echo e($key); ?>][start_time]" class="border rounded px-2 py-1">
                        <span>–</span>
                        <input type="time" name="working_hours[<?php echo e($key); ?>][end_time]" class="border rounded px-2 py-1">
                        <label class="ml-4 flex items-center space-x-2">
                            <input type="hidden" name="working_hours[<?php echo e($key); ?>][day_off]" value="0">
                            <input type="checkbox" name="working_hours[<?php echo e($key); ?>][day_off]" value="1">
                            <span>Вихідний</span>
                        </label>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="flex items-center">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    💾 Зберегти
                </button>
                <a href="<?php echo e(route('admin.masters.index')); ?>" class="ml-4 text-blue-500 hover:underline">← Назад до списку</a>
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
<?php /**PATH C:\xampp\htdocs\diplom-salon\resources\views/admin/masters/create.blade.php ENDPATH**/ ?>