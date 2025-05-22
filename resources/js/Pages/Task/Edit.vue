<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex-1 p-8">
                    <div class="mx-auto bg-white overflow-hidden shadow-sm rounded-lg">
                        <!-- Шапка формы -->
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h1 class="text-2xl font-bold text-gray-800">Изменить задачу</h1>
                            <Link
                                :href="route('task.index')"
                                class="text-sky-500 hover:text-sky-600 transition-colors flex items-center"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                                Назад к списку
                            </Link>
                        </div>

                        <!-- Основное содержимое формы -->
                        <div class="p-6">
                            <form @submit.prevent="update" class="space-y-6">
                                <div class="flex space-x-4">
                                    <!-- Выбор проекта -->
                                    <div class="w-1/3">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Проект</label>
                                        <select
                                            v-model="project_id"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed"
                                            required
                                        >
                                            <option :value="project_id" selected>
                                                {{
                                                    projects.find(p => p.id === project_id)?.title || 'Неизвестный проект'
                                                }}
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Выбор приоритета -->
                                    <div class="w-1/3">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Приоритет</label>
                                        <div class="relative">
                                            <select
                                                v-model="priority_id"
                                                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 appearance-none"
                                            >
                                                <option value="" disabled selected>Выберите приоритет</option>
                                                <option
                                                    v-for="priority in priorities"
                                                    :value="priority.id"
                                                    :key="priority.id"
                                                >
                                                    {{ priority.name }}
                                                </option>
                                            </select>
                                            <!-- Цветной индикатор -->
                                            <div
                                                v-if="priority_id"
                                                class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 rounded-sm"
                                                :style="{ backgroundColor: priorities.find(p => p.id === priority_id)?.color || 'transparent' }"
                                            ></div>
                                            <!-- Иконка стрелки -->
                                            <div
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Выбор исполнителя-->
                                    <div class="w-1/3">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Исполнитель</label>
                                        <select
                                            v-model="contractor_id"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                                            :disabled="!project_id"
                                        >
                                            <option value="" disabled selected>
                                                {{ project_id ? 'Выберите исполнителя' : 'Сначала выберите проект' }}
                                            </option>
                                            <option
                                                v-for="user in getProjectUsers(project_id)"
                                                :value="user.id"
                                                :key="user.id"
                                            >
                                                {{ user.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex space-x-4">
                                    <!-- Статус -->
                                    <div class="w-1/3">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Статус</label>
                                        <div class="relative">
                                            <select
                                                v-model="status_id"
                                                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 appearance-none"
                                            >
                                                <option v-for="status in statuses"
                                                        :value="status.id"
                                                        :key="status.id"
                                                        :style="{ color: status.color }">
                                                    {{ status.name }}
                                                </option>
                                            </select>
                                            <!-- Цветной индикатор -->
                                            <div
                                                v-if="status_id"
                                                class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 rounded-sm"
                                                :style="{ backgroundColor: statuses.find(s => s.id === status_id)?.color || 'transparent' }"
                                            ></div>
                                        </div>
                                    </div>
                                    <!-- Дата начала -->
                                    <div class="w-1/3">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Дата начала</label>
                                        <input
                                            type="date"
                                            v-model="start_date"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                                        >
                                    </div>

                                    <!-- Дата окончания -->
                                    <div class="w-1/3">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Дата
                                            окончания</label>
                                        <input
                                            type="date"
                                            v-model="due_date"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                                        >
                                    </div>
                                </div>

                                <!-- Название задачи -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Название задачи</label>
                                    <input
                                        v-model="title"
                                        type="text"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                                        placeholder="Введите название задачи"
                                        required
                                    >
                                </div>

                                <!-- Описание с Quill Editor -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Описание задачи</label>
                                    <div ref="editorContainer" class="ql-editor-container"></div>
                                    <input type="hidden" name="description" v-model="description">
                                </div>

                                <!-- После блока с Quill Editor добавьте: -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Файлы задачи</label>

                                    <!-- Текущие файлы -->
                                    <div v-if="existingFiles.length" class="mb-4 space-y-2">
                                        <div v-for="(file, index) in existingFiles" :key="'existing-'+index"
                                             class="flex items-center justify-between p-2 border border-gray-200 rounded-md">
                                            <div class="flex items-center truncate">
                                                <template v-if="file.mime.startsWith('image/')">
                                                    <img :src="file.url" class="h-8 w-8 object-cover rounded mr-2"
                                                         alt="Preview">
                                                </template>
                                                <template v-else>
                                                    <div
                                                        class="h-8 w-8 bg-gray-100 rounded mr-2 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             class="h-5 w-5 text-gray-400" fill="none"
                                                             viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                        </svg>
                                                    </div>
                                                </template>
                                                <span class="text-sm text-gray-700 truncate">{{ file.name }}</span>
                                                <span class="text-xs text-gray-500 ml-2">{{
                                                        formatFileSize(file.size)
                                                    }}</span>
                                            </div>
                                            <button type="button" @click="removeExistingFile(index)"
                                                    class="text-red-500 hover:text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                     viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                          d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Добавление новых файлов -->
                                    <div class="mt-2">
                                        <label
                                            class="cursor-pointer inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                 viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                            Добавить файлы
                                            <input type="file" class="sr-only" multiple @change="handleFileUpload">
                                        </label>
                                    </div>

                                    <!-- Новые файлы (предпросмотр) -->
                                    <div v-if="newFiles.length" class="mt-4 space-y-2">
                                        <div v-for="(file, index) in newFiles" :key="'new-'+index"
                                             class="flex items-center justify-between p-2 border border-gray-200 rounded-md">
                                            <div class="flex items-center truncate">
                                                <template v-if="isImage(file)">
                                                    <img :src="filePreview(file)"
                                                         class="h-8 w-8 object-cover rounded mr-2" alt="Preview">
                                                </template>
                                                <template v-else>
                                                    <div
                                                        class="h-8 w-8 bg-gray-100 rounded mr-2 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             class="h-5 w-5 text-gray-400" fill="none"
                                                             viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                        </svg>
                                                    </div>
                                                </template>
                                                <span class="text-sm text-gray-700 truncate">{{ file.name }}</span>
                                                <span class="text-xs text-gray-500 ml-2">{{
                                                        formatFileSize(file.size)
                                                    }}</span>
                                            </div>
                                            <button type="button" @click="removeNewFile(index)"
                                                    class="text-red-500 hover:text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                     viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                          d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Кнопка отправки -->
                                <div class="pt-2">
                                    <button
                                        type="submit"
                                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-colors"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                        Обновить задачу
                                    </button>
                                </div>
                            </form>
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
    name: "Edit",
    components: {
        Link,
        AuthenticatedLayout
    },
    props: {
        task: {
            type: Object,
            required: true,
            default: () => ({
                files: []
            })
        },
        projects: Array,
        priorities: Array,
        users: Array,
        statuses: Array,
    },
    data() {
        // Получаем базовый URL из window.location
        const baseUrl = window.location.origin;

        // Функция для подготовки списка файлов
        const prepareFiles = (files) => {
            if (!files || !Array.isArray(files)) return [];
            return files.map(file => ({
                ...file,
                // Формируем полный URL к файлу
                url: file.path ? `${baseUrl}/storage/${file.path.replace(/^storage\//, '')}` : null,
                // Добавляем mime-type если его нет
                mime: file.mime || this.getMimeTypeFromName(file.name)
            }));
        };

        return {
            id: this.task.id,
            title: this.task.title,
            description: this.task.description,
            project_id: this.task.project_id,
            priority_id: this.task.priority_id,
            contractor_id: this.task.contractor_id,
            start_date: this.task.start_date,
            due_date: this.task.due_date,
            status_id: this.task.status_id,
            quill: null,

            existingFiles: prepareFiles(this.task.files),
            newFiles: [],
            filesToDelete: []
        };
    },
    mounted() {
        // Инициализация Quill Editor
        this.initQuillEditor();
    },
    beforeUnmount() {
        this.destroyQuillEditor();
    },
    methods: {
        // Инициализация редактора
        initQuillEditor() {
            this.quill = new Quill(this.$refs.editorContainer, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{'list': 'ordered'}, {'list': 'bullet'}],
                        ['link'],
                        ['clean']
                    ]
                }
            });

            // Установка начального значения
            if (this.task.description) {
                this.quill.root.innerHTML = this.task.description;
            }

            // Обработчик изменений
            this.quill.on('text-change', () => {
                this.description = this.$refs.editorContainer.querySelector('.ql-editor').innerHTML;
            });
        },

        // Уничтожение редактора
        destroyQuillEditor() {
            if (this.quill) {
                this.quill.off('text-change');
                this.quill = null;
            }
        },

        // Обновление задачи
        async update() {
            try {
                const formData = new FormData();

                // Основные данные
                formData.append('_method', 'PATCH');
                formData.append('title', this.title);
                formData.append('description', this.description);
                formData.append('project_id', this.project_id);
                formData.append('priority_id', this.priority_id);
                formData.append('contractor_id', this.contractor_id);
                formData.append('start_date', this.start_date);
                formData.append('due_date', this.due_date);
                formData.append('status_id', this.status_id);

                // Файлы для удаления
                this.filesToDelete.forEach((fileId, index) => {
                    formData.append(`files_to_delete[${index}]`, fileId);
                });

                // Новые файлы
                this.newFiles.forEach((file, index) => {
                    formData.append(`files[${index}]`, file);
                });

                // Отправка данных
                await this.$inertia.post(`/tasks/${this.id}`, formData, {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.newFiles = [];
                        this.filesToDelete = [];
                        // Обновляем existingFiles после успешного сохранения
                        this.existingFiles = this.task.files.map(file => ({
                            ...file,
                            url: this.asset(`storage/${file.path}`)
                        }));
                    }
                });
            } catch (error) {
                console.error('Ошибка при обновлении задачи:', error);
            }
        },

        // Получение пользователей проекта
        getProjectUsers(projectId) {
            if (!projectId) return [];
            const project = this.projects.find(p => p.id === projectId);
            return project?.users || [];
        },

        // Обработка загрузки файлов
        handleFileUpload(event) {
            const files = event.target.files;
            if (!files) return;

            for (let i = 0; i < files.length; i++) {
                this.newFiles.push(files[i]);
            }
            event.target.value = '';
        },

        // Удаление существующего файла
        removeExistingFile(index) {
            const file = this.existingFiles[index];
            this.filesToDelete.push(file.id || file.path);
            this.existingFiles.splice(index, 1);
        },

        // Удаление нового файла
        removeNewFile(index) {
            this.newFiles.splice(index, 1);
        },

        // Проверка, является ли файл изображением
        isImage(file) {
            return file.type?.startsWith('image/') ||
                file.mime?.startsWith('image/') ||
                this.getMimeTypeFromName(file.name).startsWith('image/');
        },

        // Превью файла
        filePreview(file) {
            if (this.isImage(file)) {
                return file.type ? URL.createObjectURL(file) : file.url;
            }
            return null;
        },

        // Форматирование размера файла
        formatFileSize(bytes) {
            if (!bytes) return '0 B';
            if (bytes >= 1073741824) return (bytes / 1073741824).toFixed(1) + ' GB';
            if (bytes >= 1048576) return (bytes / 1048576).toFixed(1) + ' MB';
            if (bytes >= 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return bytes + ' B';
        },

        // Получение mime-type по имени файла
        getMimeTypeFromName(filename) {
            if (!filename) return 'application/octet-stream';

            const extension = filename.split('.').pop().toLowerCase();
            const mimeTypes = {
                // Images
                jpg: 'image/jpeg',
                jpeg: 'image/jpeg',
                png: 'image/png',
                gif: 'image/gif',
                webp: 'image/webp',
                svg: 'image/svg+xml',
                // Documents
                pdf: 'application/pdf',
                doc: 'application/msword',
                docx: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                xls: 'application/vnd.ms-excel',
                xlsx: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ppt: 'application/vnd.ms-powerpoint',
                pptx: 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                txt: 'text/plain',
                // Archives
                zip: 'application/zip',
                rar: 'application/x-rar-compressed',
                // Other
                mp3: 'audio/mpeg',
                mp4: 'video/mp4',
                mov: 'video/quicktime'
            };

            return mimeTypes[extension] || 'application/octet-stream';
        },

        // Формирование полного URL
        asset(path) {
            const baseUrl = window.location.origin;
            return path.startsWith('http') ? path : `${baseUrl}/${path.replace(/^\//, '')}`;
        }
    }
}
</script>

<style>
.ql-editor-container {
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    height: 200px;
}

.ql-toolbar {
    border-top-left-radius: 0.375rem;
    border-top-right-radius: 0.375rem;
    border: 1px solid #d1d5db;
    border-bottom: none;
}

.ql-container {
    border-bottom-left-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
    font-family: inherit;
    font-size: 1rem;
}

.ql-editor {
    min-height: 150px;
}
</style>
