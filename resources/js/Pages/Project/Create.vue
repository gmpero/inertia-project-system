<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Создать проект</h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Основная информация</h3>
                            <Link
                                :href="route('project.index')"
                                class="text-sky-500 hover:text-sky-600 flex items-center"
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

                        <form @submit.prevent="store" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Название проекта</label>
                                <input
                                    v-model="form.title"
                                    type="text"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500"
                                    placeholder="Введите название проекта"
                                    required
                                >
                                <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Код проекта</label>
                                <input
                                    v-model="form.code"
                                    type="text"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500"
                                    placeholder="Введите код проекта"
                                    required
                                >
                                <p v-if="form.errors.code" class="mt-1 text-sm text-red-600">{{ form.errors.code }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Описание</label>
                                <textarea
                                    v-model="form.description"
                                    rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500"
                                    placeholder="Добавьте описание проекта"
                                ></textarea>
                                <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">{{ form.errors.description }}</p>
                            </div>

                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Участники проекта</label>
                                <button
                                    type="button"
                                    @click="toggleDropdown"
                                    class="w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 text-left focus:ring-2 focus:ring-sky-500 focus:border-sky-500 flex items-center justify-between"
                                >
                                    <span class="truncate">
                                        {{ selectedUsersNames.length > 0 ? selectedUsersNames.join(', ') : 'Выберите пользователей' }}
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div v-if="dropdownOpen" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md mt-1 shadow-lg max-h-60 overflow-y-auto">
                                    <div
                                        v-for="user in users"
                                        :key="user.id"
                                        class="flex items-center px-4 py-2 cursor-pointer hover:bg-gray-100"
                                        @click="toggleUser(user)"
                                    >
                                        <input
                                            type="checkbox"
                                            :checked="form.user_ids.includes(user.id)"
                                            class="mr-2 rounded text-sky-500 focus:ring-sky-500"
                                            @click.stop
                                        />
                                        <span>{{ user.name }}</span>
                                    </div>
                                </div>
                                <p v-if="form.errors.user_ids" class="mt-1 text-sm text-red-600">{{ form.errors.user_ids }}</p>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 disabled:opacity-50"
                                >
                                    <span v-if="form.processing">Сохранение...</span>
                                    <span v-else>Сохранить проект</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, computed } from 'vue'

const props = defineProps({
    users: {
        type: Array,
        required: true,
    }
})

const dropdownOpen = ref(false)

const form = useForm({
    title: '',
    code: '',
    description: '',
    user_ids: [],
})

const selectedUsersNames = computed(() => {
    return props.users
        .filter(user => form.user_ids.includes(user.id))
        .map(user => user.name)
})

function toggleDropdown() {
    dropdownOpen.value = !dropdownOpen.value
}

function toggleUser(user) {
    const index = form.user_ids.indexOf(user.id)
    if (index === -1) {
        form.user_ids.push(user.id)
    } else {
        form.user_ids.splice(index, 1)
    }
}

function store() {
    form.post('/projects')
}
</script>

<style scoped>
/* Добавляем эти стили */
.dropdown-container {
    position: relative;
    z-index: 50;
}

.dropdown-list {
    max-height: 15rem; /* Ограничиваем высоту */
    overflow-y: auto;  /* Добавляем прокрутку */
    width: 100%;
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 50;
}

/* Убираем overflow-hidden у родительского контейнера */
.shadow-sm {
    overflow: visible !important;
}
</style>
