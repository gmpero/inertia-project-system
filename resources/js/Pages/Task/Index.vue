<template>
    <AuthenticatedLayout>
        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Фильтры -->
                <div class="bg-white p-4 rounded-lg shadow-sm mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-2 sm:space-y-0">
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
                    <div class="relative w-full sm:w-64">
                        <select
                            v-model="selectedProject"
                            class="w-full appearance-none bg-white border border-gray-300 rounded-md pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500"
                        >
                            <option :value="null">Все проекты</option>
                            <option v-for="project in uniqueProjects" :value="project.id">
                                {{ project.title }}
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Список задач с улучшенной мобильной адаптацией -->
                <div class="space-y-2">
                    <div v-for="task in filteredTasks"
                         class="card bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                        <Link :href="route('task.show', task.id)" class="block">
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-3">
                                <div class="flex-1 min-w-0">
                                    <!-- Заголовок и статус -->
                                    <div class="flex flex-col xs:flex-row xs:items-baseline gap-1.5 mb-2">
                                        <h3 class="font-medium text-lg leading-snug break-words mr-2">
                                            {{ task?.title }}
                                        </h3>
                                        <div class="flex items-center flex-shrink-0">
                                            <div
                                                class="w-3.5 h-3.5 rounded mr-1.5 flex-shrink-0"
                                                :style="{ backgroundColor: task.status?.color || '#ccc' }"
                                            ></div>
                                            <span class="text-sm text-gray-600 whitespace-nowrap">
                                                {{ task.status?.name || 'Без статуса' }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Основная информация -->
                                    <div class="space-y-1.5">
                                        <div class="text-sm text-gray-600">
                                            <span class="text-gray-500">Исполнитель:</span>
                                            {{ task.contractor?.name || "Не назначен" }}
                                        </div>

                                        <div class="flex items-center">
                                            <div
                                                class="w-3.5 h-3.5 rounded mr-1.5 flex-shrink-0"
                                                :style="{ backgroundColor: task.priority?.color || '#ccc' }"
                                            ></div>
                                            <span class="text-sm text-gray-600">
                                                {{ task.priority?.name || 'Без приоритета' }}
                                            </span>
                                        </div>

                                        <div class="text-sm text-gray-600">
                                            <span class="text-gray-500">Проект:</span>
                                            {{ task?.project?.title || 'Не указан' }}
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            <span class="text-gray-500">Номер:</span>
                                            {{ task.task_code || '—' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Дата и создатель -->
                                <div class="text-right text-xs sm:text-sm text-gray-400 mt-1 sm:mt-0 self-end sm:self-start">
                                    <div>{{ task.date }}</div>
                                    <div class="mt-0.5">Создал: {{ task.creator.name }}</div>
                                </div>
                            </div>
                        </Link>

                        <!-- Кнопки действий -->
                        <div class="mt-3 flex justify-end space-x-3">
                            <Link
                                :href="route('task.edit', task.id)"
                                class="text-blue-500 hover:text-blue-700 text-sm whitespace-nowrap"
                            >
                                Редактировать
                            </Link>
                            <Link
                                as="button"
                                method="delete"
                                :href="route('task.delete', task.id)"
                                class="text-red-600 hover:underline cursor-pointer text-sm whitespace-nowrap"
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

<script setup>
import { Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { computed, ref } from "vue";

const props = defineProps({
    tasks: {
        type: Array,
        default: () => []
    },
    auth: {
        type: Object,
        default: () => ({})
    }
});

const hideCompleted = ref(false);
const onlyMyTasks = ref(false);
const selectedProject = ref(null);

const uniqueProjects = computed(() => {
    const projects = [];
    const projectIds = new Set();

    props.tasks.forEach(task => {
        if (task.project && !projectIds.has(task.project.id)) {
            projectIds.add(task.project.id);
            projects.push(task.project);
        }
    });

    return projects;
});

const filteredTasks = computed(() => {
    return props.tasks.filter(task => {
        const isCompleted = task.status?.name?.toLowerCase().includes('готово');
        if (hideCompleted.value && isCompleted) {
            return false;
        }
        if (onlyMyTasks.value && task.contractor?.id !== props.auth.user?.id) {
            return false;
        }
        if (selectedProject.value && task.project?.id !== selectedProject.value) {
            return false;
        }
        return true;
    });
});

const deleteTask = (id) => {
    if (confirm('Вы уверены, что хотите удалить эту задачу?')) {
        Inertia.delete(route('task.destroy', id));
    }
};
</script>

<style>
.card {
    min-height: 120px;
}

@media (max-width: 640px) {
    .card {
        min-height: auto;
        padding: 0.75rem;
    }
}
</style>
