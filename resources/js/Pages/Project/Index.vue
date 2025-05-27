<template>
    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Проекты</h2>
                <Link
                    :href="route('project.create')"
                    class="hover:bg-white hover:text-sky-500 py-2 w-32 border border-sky-500 bg-sky-500 rounded-full text-center text-white text-sm"
                >
                    Создать проект
                </Link>
            </div>
        </template>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="projects" class="flex flex-col">
                    <div class="mt-4" v-for="project in projects" :key="project.id">
                        <div class="bg-white border border-gray-300 rounded-lg shadow-md p-4 w-full">
                            <h2 class="text-lg font-semibold">{{ project.title }}</h2>
                            <p class="text-gray-600">{{ project.description }}</p>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-sm text-gray-500">ID: {{ project.id }}</span>
                                <Link class="text-sky-500 hover:underline" :href="route('project.show', project.id)">
                                    Просмотреть
                                </Link>
                            </div>

                            <div class="text-right">
                                <div>
                                    <Link class="text-sky-500 hover:underline"
                                          :href="route('project.edit', project.id)">
                                        Изменить
                                    </Link>
                                </div>
                                <div>
                                    <Link
                                        as="button"
                                        method="delete"
                                        :href="route('project.delete', project.id)"
                                        class="text-red-600 hover:underline cursor-pointer"
                                    >
                                        Удалить
                                    </Link>
                                </div>
                                <div class="text-sm text-gray-500 mt-2">Создано: {{ project.date }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import {Head, Link} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    name: "Index",

    props: [
        'projects'
    ],

    components: {
        Head,
        Link,
        AuthenticatedLayout,
    }
}
console.log(route('project.create'))
</script>

<style>
/* Уменьшение высоты карточек */
.card {
    min-height: 120px; /* Установите минимальную высоту по вашему усмотрению */
}
</style>
