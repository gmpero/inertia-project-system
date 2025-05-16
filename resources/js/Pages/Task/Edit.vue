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
                                    <div class="w-1/2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Проект</label>
                                        <select
                                            v-model="project_id"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
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
                                    <div class="w-1/2">
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
                                            required
                                        >
                                            <option value="" disabled selected>Выберите исполнителя</option>
                                            <option
                                                v-for="user in users"
                                                :value="user.id"
                                                :key="user.id"
                                            >
                                                {{ user.name }} (ID: {{ user.id }})
                                            </option>
                                        </select>
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
    name: "Index",
    components: {
        Link,
        AuthenticatedLayout
    },
    props: {
        task: Object,
        projects: Array,
        priorities: Array,
        users: Array,
    },
    data() {
        return {
            id: this.task.id,
            title: this.task.title,
            description: this.task.description, // HTML содержимое
            project_id: this.task.project_id,
            priority_id: this.task.priority_id,
            contractor_id: this.task.contractor_id,
            quill: null
        }
    },
    mounted() {
        // Инициализация Quill Editor
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

        // Установка начального значения из пропса
        if (this.task.description) {
            this.quill.root.innerHTML = this.task.description;
        }

        // Обновляем description при изменении содержимого
        this.quill.on('text-change', () => {
            this.description = this.$refs.editorContainer.querySelector('.ql-editor').innerHTML;
        });
    },
    beforeUnmount() {
        if (this.quill) {
            this.quill.off('text-change');
            this.quill = null;
        }
    },
    methods: {
        update() {
            // Получаем текущее HTML содержимое редактора
            const descriptionHtml = this.$refs.editorContainer.querySelector('.ql-editor').innerHTML;

            this.$inertia.patch(`/tasks/${this.id}`, {
                title: this.title,
                description: descriptionHtml,
                project_id: this.project_id,
                priority_id: this.priority_id,
                contractor_id: this.contractor_id,
            });
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
