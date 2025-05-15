<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Список задач -->
                <div class="space-y-4">
                    <div v-for="task in tasks"
                         class="card bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                        <Link :href="route('task.show', task.id)" class="block">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium text-lg">{{ task?.title }}</h3>
                                    <p class="text-gray-600 text-sm">Задача для проекта:
                                        {{ task?.project?.title || 'Не указан' }}</p>
                                    <p class="text-gray-600 text-sm">Номер задачи: {{
                                            task.task_code || 'Не указан'
                                        }}</p>
                                </div>
                                <span class="text-gray-400 text-sm">{{ task.date }}</span>
                            </div>
                        </Link>

                        <div class="mt-3 flex justify-end space-x-2">
                            <Link
                                :href="route('task.edit', task.id)"
                                class="text-blue-500 hover:text-blue-700 text-sm"
                            >
                                Редактировать
                            </Link>
                            <Link
                                as="button"
                                method="delete"
                                :href="route('task.delete', task.id)"
                                class="text-red-600 hover:underline cursor-pointer"
                            >
                                Удалить
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import {Link} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    name: "Index",
    components: {
        Link,
        AuthenticatedLayout,
    },
    props: {
        tasks: {
            type: Array,
            default: () => []
        },
    },
    methods: {
        deleteTask(id) {
            if (confirm('Вы уверены, что хотите удалить эту задачу?')) {
                this.$inertia.delete(route('task.destroy', id));
            }
        }
    }
}
</script>

<style>
.card {
    min-height: 120px;
}
</style>
