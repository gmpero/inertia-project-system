<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Отчет по задаче: {{ task.title }}</h2>

                <!-- Кнопка печати -->
                <button @click="printReport"
                        class="hover:bg-white hover:text-sky-500 py-2 w-32 border border-sky-500 bg-sky-500 rounded-full text-center text-white text-sm">
                    Печать отчета
                </button>
            </div>
        </template>
        <div class="bg-white">
            <div class="max-w-7xl mx-auto py-6  sm:px-6 lg:px-8">


                <!-- Область отчета -->
                <div class="printable-content bg-white p-6 rounded-lg">
                    <h1 class="text-2xl font-bold mb-6">Отчет по задаче: {{ task.title }}</h1>

                    <!-- Общая информация -->
                    <div class="grid grid-cols-3 gap-4 mb-8">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-blue-800">Общее время</h3>
                            <p class="text-3xl">{{ totalTime }} ч</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-green-800">Записей</h3>
                            <p class="text-3xl">{{ timeEntries.length }}</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-yellow-800">Участников</h3>
                            <p class="text-3xl">{{ Object.keys(timeByUsers).length }}</p>
                        </div>
                    </div>

                    <!-- Таблица участников -->
                    <div class="mb-8">
                        <h3 class="font-semibold text-lg mb-4">Участники</h3>
                        <table class="min-w-full border">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 border">Имя</th>
                                <th class="py-2 px-4 border">Время</th>
                                <th class="py-2 px-4 border">%</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(userReport, userId) in timeByUsers" :key="userId">
                                <td class="py-2 px-4 border">{{ userReport.user.name }}</td>
                                <td class="py-2 px-4 border">{{ userReport.total_time }} ч</td>
                                <td class="py-2 px-4 border">{{
                                        ((userReport.total_time / totalTime) * 100).toFixed(1)
                                    }}%
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Детализация -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4">Детализация времени</h3>
                        <table class="min-w-full border">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 border">Дата</th>
                                <th class="py-2 px-4 border">Участник</th>
                                <th class="py-2 px-4 border">Время</th>
                                <th class="py-2 px-4 border">Комментарий</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="entry in timeEntries" :key="entry.id">
                                <td class="py-2 px-4 border">{{ entry.created_at }}</td>
                                <td class="py-2 px-4 border">{{ entry.user.name }}</td>
                                <td class="py-2 px-4 border">{{ (entry.minutes) / 60 }} ч</td>
                                <td class="py-2 px-4 border">{{ entry.comment || '-' }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {Head, Link} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    task: Object,
    timeEntries: Array,
    totalTime: Number,
    timeByUsers: Object
});

const printReport = () => {
    if (typeof window !== 'undefined') {
        window.print();
    }
};
</script>

<style scoped>
@media print {
    button {
        display: none;
    }

    body, .printable-content {
        padding: 0;
        margin: 0;
        background: white;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }
}
</style>
