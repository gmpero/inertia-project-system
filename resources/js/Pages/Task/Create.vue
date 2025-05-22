<template>
    <AuthenticatedLayout>
        <div class="py-6 sm:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <!-- Шапка формы -->
                        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Создание новой задачи</h1>
                            <Link
                                :href="route('task.index')"
                                class="text-sky-500 hover:text-sky-600 transition-colors flex items-center text-sm sm:text-base"
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
                        <div class="p-4 sm:p-6">
                            <form @submit.prevent="store" class="space-y-4 sm:space-y-6">
                                <!-- Группа полей - теперь в колонку на мобильных -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <!-- Выбор проекта -->
                                    <div class="sm:col-span-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Проект</label>
                                        <select
                                            v-model="form.project_id"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 text-sm sm:text-base"
                                            required
                                        >
                                            <option value="" disabled selected>Выберите проект</option>
                                            <option
                                                v-for="project in projects"
                                                :value="project.id"
                                                :key="project.id"
                                            >
                                                {{ project.title }} (ID: {{ project.id }})
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Выбор приоритета -->
                                    <div class="sm:col-span-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Приоритет</label>
                                        <div class="relative">
                                            <select
                                                v-model="form.priority_id"
                                                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 appearance-none text-sm sm:text-base"
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
                                                v-if="form.priority_id"
                                                class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 rounded-sm"
                                                :style="{ backgroundColor: priorities.find(p => p.id === form.priority_id)?.color || 'transparent' }"
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

                                    <!-- Выбор исполнителя -->
                                    <div class="sm:col-span-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Исполнитель</label>
                                        <select
                                            v-model="form.contractor_id"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 text-sm sm:text-base"
                                            :disabled="!form.project_id"
                                        >
                                            <option value="" disabled selected>
                                                {{ form.project_id ? 'Выберите исполнителя' : 'Сначала выберите проект' }}
                                            </option>
                                            <option
                                                v-for="user in getProjectUsers(form.project_id)"
                                                :value="user.id"
                                                :key="user.id"
                                            >
                                                {{ user.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <!-- Выбор Статуса -->
                                    <!-- <div class="sm:col-span-1">-->
                                    <!--                                        <label class="block text-sm font-medium text-gray-700 mb-1">Статус</label>-->
                                    <!--                                        <select-->
                                    <!--                                            v-model="form.project_id"-->
                                    <!--                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 text-sm sm:text-base"-->
                                    <!--                                            required-->
                                    <!--                                        >-->
                                    <!--                                            <option value="" disabled selected>Выберите проект</option>-->
                                    <!--                                            <option-->
                                    <!--                                                v-for="project in projects"-->
                                    <!--                                                :value="project.id"-->
                                    <!--                                                :key="project.id"-->
                                    <!--                                            >-->
                                    <!--                                                {{ project.title }} (ID: {{ project.id }})-->
                                    <!--                                            </option>-->
                                    <!--                                        </select>-->
                                    <!--                                    </div>-->

                                    <!-- Дата начала -->
                                    <div class="sm:col-span-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Дата начала</label>
                                        <input
                                            type="date"
                                            v-model="form.start_date"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 text-sm sm:text-base"
                                        >
                                    </div>

                                    <!-- Дата окончания -->
                                    <div class="sm:col-span-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Дата окончания</label>
                                        <input
                                            type="date"
                                            v-model="form.due_date"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 text-sm sm:text-base"
                                        >
                                    </div>
                                </div>

                                <!-- Название задачи -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Название задачи</label>
                                    <input
                                        v-model="form.title"
                                        type="text"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 text-sm sm:text-base"
                                        placeholder="Введите название задачи"
                                        required
                                    >
                                </div>

                                <!-- Описание с Quill Editor -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Описание задачи</label>
                                    <div ref="editorContainer" class="ql-editor-container"></div>
                                    <input type="hidden" name="description" v-model="form.description">
                                </div>

                                <!-- Загрузка файлов -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Прикрепленные файлы</label>
                                    <div class="mt-1 flex flex-col sm:flex-row sm:items-center gap-2">
                                        <label
                                            class="cursor-pointer bg-white rounded-md font-medium text-sky-500 hover:text-sky-600 focus-within:outline-none inline-flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                            </svg>
                                            <span>Выберите файлы</span>
                                            <input
                                                type="file"
                                                class="sr-only"
                                                multiple
                                                @change="handleFileUpload"
                                            >
                                        </label>
                                        <span class="text-xs sm:text-sm text-gray-500">или перетащите файлы сюда</span>
                                    </div>

                                    <!-- Предпросмотр загруженных файлов -->
                                    <div v-if="form.files.length > 0" class="mt-4 space-y-2">
                                        <div v-for="(file, index) in form.files" :key="index"
                                             class="flex items-center justify-between p-2 border border-gray-200 rounded-md">
                                            <div class="flex items-center min-w-0">
                                                <template v-if="isImage(file)">
                                                    <img :src="filePreview(file)"
                                                         class="h-10 w-10 object-cover rounded mr-2" alt="Preview">
                                                </template>
                                                <template v-else>
                                                    <div
                                                        class="h-10 w-10 bg-gray-100 rounded mr-2 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             class="h-6 w-6 text-gray-400" fill="none"
                                                             viewBox="0 0 24 24"
                                                             stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                        </svg>
                                                    </div>
                                                </template>
                                                <span class="text-sm text-gray-700 truncate">{{ file.name }}</span>
                                            </div>

                                            <button
                                                type="button"
                                                @click="removeFile(index)"
                                                class="text-red-500 hover:text-red-700 ml-2"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                     viewBox="0 0 20 20"
                                                     fill="currentColor">
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
                                        class="w-full flex justify-center py-2 sm:py-3 px-4 border border-transparent rounded-md shadow-sm text-sm sm:text-base font-medium text-white bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-colors"
                                        :disabled="isSubmitting"
                                    >
                                        <svg v-if="isSubmitting" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                             viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                        {{ isSubmitting ? 'Создание...' : 'Создать задачу' }}
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
    name: "TaskCreate",
    components: {
        Link,
        AuthenticatedLayout,
    },
    props: {
        projects: Array,
        priorities: Array,
        users: Array,
    },
    data() {
        return {
            isSubmitting: false,
            quill: null,
            form: {
                project_id: '',
                priority_id: '',
                title: '',
                description: '',
                contractor_id: '',
                start_date: '',
                due_date: '',
                files: []
            }
        }
    },
    mounted() {
        this.quill = new Quill(this.$refs.editorContainer, {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{'list': 'ordered'}, {'list': 'bullet'}],
                    ['link'],
                    ['clean']
                ]
            },
            placeholder: 'Детальное описание задачи...'
        });

        this.quill.on('text-change', () => {
            this.form.description = this.$refs.editorContainer.querySelector('.ql-editor').innerHTML;
        });
    },
    beforeUnmount() {
        if (this.quill) {
            this.quill.off('text-change');
            this.quill = null;
        }
    },
    methods: {
        store() {
            this.isSubmitting = true;
            const formData = new FormData();
            formData.append('project_id', this.form.project_id);
            formData.append('priority_id', this.form.priority_id);
            formData.append('title', this.form.title);
            formData.append('description', this.form.description);
            formData.append('contractor_id', this.form.contractor_id);
            formData.append('start_date', this.form.start_date);
            formData.append('due_date', this.form.due_date);

            this.form.files.forEach((file, index) => {
                formData.append(`files[${index}]`, file);
            });

            this.$inertia.post('/tasks', formData, {
                preserveScroll: true,
                onSuccess: () => {
                    this.isSubmitting = false;
                },
                onError: () => {
                    this.isSubmitting = false;
                }
            });
        },
        handleFileUpload(event) {
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                this.form.files.push(files[i]);
            }
            event.target.value = '';
        },
        removeFile(index) {
            this.form.files.splice(index, 1);
        },
        isImage(file) {
            return file.type.startsWith('image/');
        },
        filePreview(file) {
            return URL.createObjectURL(file);
        },

        getProjectUsers(projectId) {
            if (!projectId) return [];
            const project = this.projects.find(p => p.id === projectId);
            return project?.users || [];
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
