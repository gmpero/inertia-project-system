<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">Задача {{ task.task_code }}</h2>
        </template>

        <div class="py-4 sm:py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div v-if="task" class="space-y-4 sm:space-y-6">
                    <!-- Информация о создателе -->
                    <div class="text-xs sm:text-sm text-gray-500 flex flex-wrap gap-x-2">
                        <span>Создана: {{ task.creator.name }}</span>
                        <span>•</span>
                        <span>{{ task.date }}</span>
                    </div>

                    <!-- Заголовок задачи и приоритет -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">{{ task.title }}</h1>

                        <div class="border border-gray-300 rounded-lg p-2 sm:p-3 w-full sm:w-auto">
                            <div class="grid grid-cols-2 gap-x-2 gap-y-1 sm:grid-cols-[auto_1fr] sm:gap-x-3">
                                <!-- Приоритет -->
                                <span class="text-gray-500 text-xs sm:text-sm sm:text-right flex items-center justify-end h-6">Приоритет:</span>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 sm:w-6 sm:h-6 rounded mr-1 sm:mr-2"
                                         :style="{ backgroundColor: task.priority?.color || '#ccc' }"></div>
                                    <span class="text-xs sm:text-sm font-medium">{{ task.priority?.name || 'Без приоритета' }}</span>
                                </div>

                                <!-- Статус -->
                                <span class="text-gray-500 text-xs sm:text-sm sm:text-right flex items-center justify-end h-6">Статус:</span>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 sm:w-6 sm:h-6 rounded mr-1 sm:mr-2"
                                         :style="{ backgroundColor: task.status?.color || '#ccc' }"></div>
                                    <span class="text-xs sm:text-sm font-medium">{{ task.status?.name || 'Без статуса' }}</span>
                                </div>

                                <!-- Исполнитель -->
                                <span class="text-gray-500 text-xs sm:text-sm sm:text-right">Исполнитель:</span>
                                <span class="text-xs sm:text-sm font-medium truncate">{{ task.contractor?.name ?? 'Не назначен' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Описание задачи -->
                    <div class="prose max-w-none text-sm sm:text-base" v-html="task.description"></div>

                    <!-- Прикрепленные файлы -->
                    <div v-if="task.files && task.files.length" class="mt-4 sm:mt-6">
                        <h3 class="text-sm sm:text-md font-medium text-gray-900 mb-2">Прикрепленные файлы</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2">
                            <div v-for="(file, index) in task.files" :key="index"
                                 class="border border-gray-400 rounded hover:shadow-sm transition-shadow text-center">
                                <!-- Превью файла -->
                                <a :href="file.url" target="_blank" class="block">
                                    <!-- Для изображений -->
                                    <div v-if="file.mime.startsWith('image/')"
                                         class="h-12 sm:h-14 bg-gray-100 flex items-center justify-center overflow-hidden">
                                        <img :src="file.url" :alt="file.name"
                                             class="max-h-full max-w-full object-cover">
                                    </div>

                                    <!-- Для других файлов -->
                                    <div v-else class="h-12 sm:h-14 bg-gray-50 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-gray-400" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                </a>

                                <!-- Название и размер файла -->
                                <div class="p-1 border-t border-gray-100 bg-white">
                                    <div class="truncate px-1 text-xs" :title="file.name">{{ file.name }}</div>
                                    <div class="text-gray-500 text-[0.6rem] sm:text-xxs mt-0.5">{{ formatFileSize(file.size) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Дополнительная информация -->
                    <div class="text-xs sm:text-sm text-gray-500 space-y-1">
                        <div>ID задачи: {{ task.id }}</div>
                        <div>Код задачи: {{ task.task_code }}</div>
                    </div>
                </div>

                <!-- Сообщения -->
                <div class="mt-8 sm:mt-12 space-y-6 sm:space-y-8">
                    <MessageList :messages="task.messages"/>
                    <MessageForm :task-id="task.id" class="mb-6 sm:mb-8"/>
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
    },
    computed: {
        rawDescription() {
            return { __html: this.task.description || '' };
        }
    },
    methods: {
        formatFileSize(bytes) {
            if (bytes >= 1073741824) return (bytes / 1073741824).toFixed(1) + ' GB';
            if (bytes >= 1048576) return (bytes / 1048576).toFixed(1) + ' MB';
            if (bytes >= 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return bytes + ' B';
        }
    }
}
</script>
