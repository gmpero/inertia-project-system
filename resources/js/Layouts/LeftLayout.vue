<template>
    <div class="flex h-screen"> <!-- Убедитесь, что контейнер занимает всю высоту экрана -->
        <aside class="w-48 bg-white border-r border-gray-300 shadow-md p-4"> <!-- Изменена ширина и цвет фона -->
            <h2 class="text-lg font-bold mb-4">Навигация</h2>
            <ul class="space-y-2">
                <li>
                    <inertia-link href="#" class="block hover:text-blue-600">Проекты</inertia-link>
                </li>
                <li>
                    <inertia-link href="#" class="block hover:text-blue-600">Сохраненные поиски</inertia-link>
                </li>
                <li>
                    <inertia-link href="#" class="block hover:text-blue-600">Фильтрация</inertia-link>
                </li>
                <li>
                    <inertia-link href="#" class="block hover:text-blue-600">Дополнительная опция</inertia-link>
                </li>
            </ul>
        </aside>
        <main class="flex-1 p-4">
            <!-- Основное содержимое страницы здесь -->
        </main>
    </div>
</template>

<script>
export default {
    // Здесь можно добавить любые необходимые свойства или методы
}
</script>

<style scoped>
/* Дополнительные стили, если необходимо */
</style>
