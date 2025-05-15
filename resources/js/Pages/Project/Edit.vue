<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактирование проекта: {{project.title}}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div>
                    <form @submit.prevent="update">
                        <div class="mb-3">
                            <input v-model="title" class="w-full rounded-full border-gray-400" type="text"
                                   placeholder="Название">
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
        AuthenticatedLayout,
    },
    props: [
        'project'
    ],
    data() {
        return {
            id: this.project.id,
            title: this.project.title,
            description: this.project.description,
            code: this.project.code,
        }
    },
    methods: {
        update() {
            this.$inertia.patch(`/projects/${this.id}`, {
                title: this.title,
                description: this.description,
                code: this.code
            })
        }
    }


}
</script>

<style scoped>

</style>
