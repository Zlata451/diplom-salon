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
            <?php echo e(__('Контакти')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-10 max-w-4xl mx-auto px-6 space-y-6 bg-white shadow rounded">
        <div>
            <h3 class="text-lg font-semibold text-pink-600">Салон краси "Kinshiriru"</h3>
            <p class="text-gray-700 mt-2">вул. Гарна, 12, м. Львів, Україна</p>
        </div>

        <div>
            <h4 class="font-medium text-gray-800">Графік роботи:</h4>
            <ul class="text-gray-600 list-disc list-inside mt-1">
                <li>Пн-Пт: 09:00 — 19:00</li>
                <li>Сб: 10:00 — 17:00</li>
                <li>Нд: вихідний</li>
            </ul>
        </div>

        <div>
            <h4 class="font-medium text-gray-800">Зв'язок:</h4>
            <p class="text-gray-700 mt-1">
                📞 +38 (099) 123-45-67<br>
                📧 info@beauty-salon.ua
            </p>
        </div>

        <div>
            <h4 class="font-medium text-gray-800">Ми на мапі:</h4>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2587.612574757919!2d24.029717115704488!3d49.839683779393576!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x473add6b451ec5ff%3A0xc5f302ff3f9dbb5c!2z0JvQvtC_0L7QtNC40L3QsCDQn9GA0L7RgdGC0YwsINCb0YzQstCw0YDQvdC-0LLQsCwg0KPQutGA0LDQuNC90LrQsNGP!5e0!3m2!1suk!2sua!4v1711911111111!5m2!1suk!2sua"
                width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
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
<?php /**PATH C:\xampp\htdocs\diplom-salon\resources\views/contact.blade.php ENDPATH**/ ?>