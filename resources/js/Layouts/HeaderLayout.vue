<template>
    <header class="flex items-center bg-white shadow-sm py-2 px-4">
        <div class="flex items-center">
            <h1 class="text-xl font-bold">{{appName}}</h1>
            <nav class="flex items-center space-x-4 ml-12">
                <Link class="hover:text-sky-500"
                      :href="route('project.index')">
                    Проекты
                </Link>
                <Link class="hover:text-sky-500"
                      :href="route('task.index')">
                    Задачи
                </Link>
                <inertia-link href="/team" class="hover:text-gray-600">Команда</inertia-link>
                <inertia-link href="/reports" class="hover:text-gray-600">Отчеты</inertia-link>
                <Link class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600"
                      :href="route('task.create')">
                    Создать задачу
                </Link>
            </nav>
        </div>
        <div class="flex items-center space-x-4 ml-auto">
            <inertia-link href="/profile" class="hover:text-gray-600">Профиль</inertia-link>
            <inertia-link href="/settings" class="hover:text-gray-600">Настройки</inertia-link>
        </div>
    </header>
    <slot />
</template>

<script>
import {Link} from "@inertiajs/vue3";

export default {
    components: {Link},
    props: {
        appName: {
            type: String,
            default: 'СУП',
        },
    },
}
</script>

<style scoped>
/* Дополнительные стили, если необходимо */
</style>
