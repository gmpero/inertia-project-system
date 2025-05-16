<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Задача {{ task.task_code }}</h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="task" class="space-y-6">
                    <!-- Информация о создателе -->
                    <div class="text-sm text-gray-500">
                        <span>Создана: {{ task.creator.name }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ task.date }}</span>
                    </div>

                    <!-- Заголовок задачи с приоритетом в одной строке -->
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-bold text-gray-900 mr-5">{{ task.title }}</h1>
                        <div class="border border-gray-300 rounded-lg p-3">
                            <div class="grid grid-cols-[auto_1fr] items-center gap-x-3 gap-y-1">
                                <!-- Приоритет -->
                                <span class="text-gray-500 text-right flex items-center justify-end h-6">Приоритет:</span>
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded mr-2"
                                         :style="{ backgroundColor: task.priority?.color || '#ccc' }"></div>
                                    <span class="text-sm font-medium">{{ task.priority?.name || 'Без приоритета' }}</span>
                                </div>

                                <!-- Исполнитель -->
                                <span class="text-gray-500 text-right">Исполнитель:</span>
                                <span class="font-medium">{{ task.contractor?.name ?? 'Не назначен' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Описание задачи -->
                    <div class="prose max-w-none" v-html="task.description"></div>

                    <!-- Дополнительная информация -->
                    <div class="text-sm text-gray-500">
                        <div>ID задачи: {{ task.id }}</div>
                        <div>Код задачи: {{ task.task_code }}</div>
                    </div>
                </div>

                <!-- Сообщения -->
                <div class="mt-12 space-y-8">
                    <MessageList :messages="task.messages"/>
                    <MessageForm :task-id="task.id" class="mb-8"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import {Link} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import MessageForm from '../Task/Partials/MessageForm.vue'
import MessageList from '../Task/Partials/MessageList.vue'

export default {
    name: "Index",
    props: ['task'],
    components: {
        Link,
        MessageForm,
        MessageList,
        AuthenticatedLayout,
    }
}
</script>

<style scoped>
/* Дополнительные стили при необходимости */
</style>
