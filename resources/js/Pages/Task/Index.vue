<template>
    <AuthenticatedLayout>
        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Фильтры -->
                <div class="bg-white p-4 rounded-lg shadow-sm mb-4 flex justify-between items-center">
                    <div class="flex space-x-4 items-center">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input
                                type="checkbox"
                                v-model="onlyMyTasks"
                                class="rounded border-gray-300 text-sky-600 focus:ring-sky-500"
                            >
                            <span class="text-sm text-gray-700">Назначенные на меня</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input
                                type="checkbox"
                                v-model="hideCompleted"
                                class="rounded border-gray-300 text-sky-600 focus:ring-sky-500"
                            >
                            <span class="text-sm text-gray-700">Скрыть завершённые задачи</span>
                        </label>
                    </div>

                    <!-- Фильтр по проекту -->
                    <div class="relative">
                        <select
                            v-model="selectedProject"
                            class="appearance-none bg-white border border-gray-300 rounded-md pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500"
                        >
                            <option :value="null">Все проекты</option>
                            <option v-for="project in uniqueProjects" :value="project.id">
                                {{ project.title }}
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Список задач -->
                <div class="space-y-2">
                    <div v-for="task in filteredTasks"
                         class="card bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                        <Link :href="route('task.show', task.id)" class="block">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div>
                                        <div class="mt-2 flex items-center">
                                            <h3 class="font-medium text-lg mr-2">{{ task?.title }}</h3>
                                            <!-- Цветной квадратик -->
                                            <div
                                                class="w-4 h-4 rounded mr-2"
                                                :style="{ backgroundColor: task.status?.color || '#ccc' }"
                                            ></div>
                                            <!-- Название приоритета -->
                                            <span class="text-sm text-gray-600">{{
                                                    task.status?.name || 'Без приоритета'
                                                }}</span>
                                        </div>

                                        <div class="text-sm text-gray-600">
                                            Исполнитель: {{task.contractor?.name || "Без исполнителя"}}
                                        </div>

                                        <div class="mt-2 flex items-center">
                                            <!-- Цветной квадратик -->
                                            <div
                                                class="w-4 h-4 rounded mr-2"
                                                :style="{ backgroundColor: task.priority?.color || '#ccc' }"
                                            ></div>
                                            <!-- Название приоритета -->
                                            <span class="text-sm text-gray-600">{{
                                                    task.priority?.name || 'Без приоритета'
                                                }}</span>
                                        </div>

                                    </div>

                                    <p class="text-gray-600 text-sm">Задача для проекта:
                                        {{ task?.project?.title || 'Не указан' }}</p>
                                    <p class="text-gray-600 text-sm">Номер задачи: {{
                                            task.task_code || 'Не указан'
                                        }}</p>
                                </div>
                                <div>
                                    <div class="text-gray-400 text-sm">{{ task.date }}</div>
                                    <div class="text-gray-400 text-sm">Создана: {{ task.creator.name }}</div>
                                </div>
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
    data() {
        return {
            hideCompleted: false,
            onlyMyTasks: false,
            selectedProject: null,
        }
    },
    props: {
        tasks: {
            type: Array,
            default: () => []
        },
        auth: {
            type: Object,
            default: () => ({})
        }
    },
    computed: {
        // Уникальные проекты для выпадающего списка
        uniqueProjects() {
            const projects = [];
            const projectIds = new Set();

            this.tasks.forEach(task => {
                if (task.project && !projectIds.has(task.project.id)) {
                    projectIds.add(task.project.id);
                    projects.push(task.project);
                }
            });

            return projects;
        },

        filteredTasks() {
            return this.tasks.filter(task => {
                // Проверка на скрытие завершённых задач
                const isCompleted = task.status?.name?.toLowerCase().includes('готово');
                if (this.hideCompleted && isCompleted) {
                    return false;
                }

                // Проверка на "только мои задачи"
                if (this.onlyMyTasks && task.contractor.id !== this.auth.user?.id) {
                    return false;
                }

                // Проверка на выбранный проект
                if (this.selectedProject && task.project?.id !== this.selectedProject) {
                    return false;
                }

                return true;
            });
        }
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
