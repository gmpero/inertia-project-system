<script setup>
import {Head, Link} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    project: Object,
    reportData: Object,
});

const printReport = () => {
    if (typeof window !== 'undefined') {
        window.print();
    }
};
</script>

<template>
    <AuthenticatedLayout>

        <!-- Основной контент -->
        <div class="py-5 bg-white">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
                <!-- Область для печати -->
                <div class="printable-content">
                    <Head title="Отчет по проекту"/>
                    <h1 class="text-2xl font-bold mb-6">Отчет по проекту: {{ project.title }}</h1>

                    <!-- Общая статистика -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-blue-800">Всего задач</h3>
                            <p class="text-3xl">{{ reportData.totalTasks }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-green-800">Выполнено</h3>
                            <p class="text-3xl">{{ reportData.completedTasks }}</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-yellow-800">Не выполнено</h3>
                            <p class="text-3xl">{{ reportData.incompleteTasks }}</p>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-red-800">Просрочено</h3>
                            <p class="text-3xl">{{ reportData.overdueTasks }}</p>
                        </div>
                    </div>

                    <!-- Прогресс-бар -->
                    <div class="mb-8">
                        <h3 class="font-semibold mb-2">
                            Процент завершения: {{ reportData.completionPercentage }}%
                        </h3>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div
                                class="bg-blue-600 h-4 rounded-full"
                                :style="`width: ${reportData.completionPercentage}%`"
                            ></div>
                        </div>
                    </div>

                    <!-- Таблица выполненных задач -->
                    <div class="mb-8">
                        <h3 class="font-semibold text-lg mb-4">Выполненные задачи</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-2 px-4 border">Задача</th>
                                    <th class="py-2 px-4 border">Исполнитель</th>
                                    <th class="py-2 px-4 border">Дата завершения</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="task in reportData.completedTasksDetails"
                                    :key="task.id"
                                    class="hover:bg-gray-50"
                                >
                                    <td class="py-2 px-4 border">
                                        <Link
                                            :href="route('task.show', task.id)"
                                            class="text-blue-600 hover:underline"
                                        >
                                            {{ task.name }}
                                        </Link>
                                    </td>
                                    <td class="py-2 px-4 border">{{ task.assigned_to }}</td>
                                    <td class="py-2 px-4 border">{{ task.completed_at }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Таблица невыполненных задач -->
                    <div class="mb-8">
                        <h3 class="font-semibold text-lg mb-4">Невыполненные задачи</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-2 px-4 border">Задача</th>
                                    <th class="py-2 px-4 border">Исполнитель</th>
                                    <th class="py-2 px-4 border">Срок</th>
                                    <th class="py-2 px-4 border">Статус</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="task in reportData.incompleteTasksDetails"
                                    :key="task.id"
                                    :class="task.is_overdue ? 'bg-red-50' : ''"
                                    class="hover:bg-gray-50"
                                >
                                    <td class="py-2 px-4 border">
                                        <Link
                                            :href="route('task.show', task.id)"
                                            class="text-blue-600 hover:underline"
                                        >
                                            {{ task.name }}
                                        </Link>
                                    </td>
                                    <td class="py-2 px-4 border">{{ task.assigned_to }}</td>
                                    <td class="py-2 px-4 border">{{ task.end_date }}</td>
                                    <td class="py-2 px-4 border">
                                        <span v-if="task.is_overdue" class="text-red-600">Просрочено</span>
                                        <span v-else>В работе</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <button @click="printReport" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Печать отчета
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Стили для обычного отображения */
.no-print {
    display: block;
}

@media print {
    /* Скрываем всё кроме области печати */
    body > *:not(.printable-area) {
        display: none !important;
    }

    /* Стили для области печати */
    .printable-area {
        display: block !important;
        width: 100%;
        padding: 0;
        margin: 0;
    }

    /* Скрываем кнопку печати */
    .no-print {
        display: none !important;
    }

    /* Улучшаем отображение таблиц при печати */
    table {
        width: 100% !important;
        border-collapse: collapse !important;
    }

    th, td {
        border: 1px solid #ddd !important;
        padding: 8px !important;
    }

    /* Убираем фоны для экономии чернил */
    * {
        background: transparent !important;
        color: #000 !important;
        box-shadow: none !important;
        text-shadow: none !important;
    }
}
</style>
