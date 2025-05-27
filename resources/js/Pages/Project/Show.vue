<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ project.title }}</h2>
        </template>

        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Карточка проекта -->
                <div class="card bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow mb-6">
                    <div class="space-y-4">
                        <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-lg text-gray-900 mb-2">Информация о проекте</h3>

                                <div class="space-y-3 text-sm">
                                    <div class="flex items-start">
                                        <span class="text-gray-500 w-24 flex-shrink-0">ID:</span>
                                        <span class="text-gray-700">{{ project.id }}</span>
                                    </div>

                                    <div class="flex items-start">
                                        <span class="text-gray-500 w-24 flex-shrink-0">Название:</span>
                                        <span class="text-gray-700">{{ project.title }}</span>
                                    </div>

                                    <div class="flex items-start">
                                        <span class="text-gray-500 w-24 flex-shrink-0">Описание:</span>
                                        <span class="text-gray-700">{{ project.description }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-sm text-gray-400 self-end sm:self-start">
                                <div>Создан: {{ project.date }}</div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <Link
                                :href="route('project.report', { project: project.id })"
                                class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors text-sm"
                            >
                                Сформировать отчет
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

defineProps({
    project: {
        type: Object,
        required: true
    }
});
</script>

<style scoped>
.card {
    transition: box-shadow 0.2s ease;
}

@media (max-width: 640px) {
    .card {
        padding: 1rem;
    }
}
</style>
