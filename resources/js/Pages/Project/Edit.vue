<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактирование проекта: {{project.title}}</h2>
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

                        <form @submit.prevent="update" class="space-y-6">
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

                            <div class="relative mb-6 dropdown-container">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Участники проекта</label>
                                <div class="relative">
                                    <button
                                        type="button"
                                        @click="toggleDropdown"
                                        class="w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 text-left focus:ring-2 focus:ring-sky-500 focus:border-sky-500 flex items-center justify-between"
                                    >
            <span class="truncate">
                {{ selectedUsers.length > 0 ? selectedUsers.map(u => u.name).join(', ') : 'Выберите пользователей' }}
            </span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <transition
                                        enter-active-class="transition ease-out duration-100"
                                        enter-from-class="transform opacity-0 scale-95"
                                        enter-to-class="transform opacity-100 scale-100"
                                        leave-active-class="transition ease-in duration-75"
                                        leave-from-class="transform opacity-100 scale-100"
                                        leave-to-class="transform opacity-0 scale-95"
                                    >
                                        <div
                                            v-if="dropdownOpen"
                                            class="dropdown-list bg-white border border-gray-300 rounded-md shadow-lg"
                                        >
                                            <div
                                                v-for="user in users"
                                                :key="user.id"
                                                class="flex items-center px-4 py-2 cursor-pointer hover:bg-gray-100"
                                                @click="toggleUser(user)"
                                            >
                                                <input
                                                    type="checkbox"
                                                    :checked="isUserSelected(user.id)"
                                                    class="mr-2 rounded text-sky-500 focus:ring-sky-500"
                                                    @click.stop
                                                />
                                                <span>{{ user.name }}</span>
                                            </div>
                                        </div>
                                    </transition>
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
                                    <span v-else>Сохранить изменения</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import {Link, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref, computed} from 'vue'

export default {
    name: "Edit",
    components: {
        Link,
        AuthenticatedLayout,
    },
    props: [
        'project',
        'users'
    ],
    setup(props) {
        const dropdownOpen = ref(false);

        const form = useForm({
            title: props.project.title,
            description: props.project.description,
            code: props.project.code,
            user_ids: props.project.users ? props.project.users.map(user => user.id) : [],
        });

        const selectedUsers = computed(() => {
            return props.users.filter(user => form.user_ids.includes(user.id));
        });

        function isUserSelected(userId) {
            return form.user_ids.includes(userId);
        }

        function toggleDropdown() {
            dropdownOpen.value = !dropdownOpen.value;
        }

        function toggleUser(user) {
            const index = form.user_ids.indexOf(user.id);
            if (index === -1) {
                form.user_ids.push(user.id);
            } else {
                form.user_ids.splice(index, 1);
            }
        }

        function update() {
            form.patch(`/projects/${props.project.id}`);
        }

        return {
            form,
            dropdownOpen,
            selectedUsers,
            isUserSelected,
            toggleDropdown,
            toggleUser,
            update
        };
    }
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
