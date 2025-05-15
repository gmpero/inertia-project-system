<template>
    <AuthenticatedLayout>
        <div class="w-96 mx-auto pt-8">
            <div class="mb-8 flex items-center justify-between"> <!-- Добавлены flex и justify-between -->
                <div>
                    <h1>Создать проект</h1>
                </div>
                <div class="ml-auto block"> <!-- или просто удалите ml-auto, т.к. justify-between уже выравнивает -->
                    <Link :href="route('project.index')" class="hover:bg-white hover:text-sky-500">Назад</Link>
                </div>
            </div>
            <div>
                <form @submit.prevent="store">
                    <div class="mb-3">
                        <input v-model="title" class="w-full rounded-full border-gray-400" type="text"
                               placeholder="Название">
                    </div>
                    <div class="mb-3">
                        <input v-model="code" class="w-full rounded-full border-gray-400" type="text"
                               placeholder="Код проекта">
                    </div>
                    <div class="mb-3">
                        <textarea v-model="description" class="w-full rounded-full border-gray-400"
                                  placeholder="Описание"></textarea>
                    </div>
                    <div class="mb-3">
                        <button
                            class="ml-auto hover:bg-white hover:text-sky-500 block p-2 w-32 border border-sky-500 bg-sky-500 rounded-full text-center text-white"
                            type="submit">Сохранить
                        </button>
                    </div>
                </form>
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
    data() {
        return {
            title: '',
            code: '',
            description: '',
        }
    },
    methods: {
        store() {
            this.$inertia.post('/projects', {title: this.title, code: this.code, description: this.description})
        }
    }


}
</script>

<style scoped>

</style>
