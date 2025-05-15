<template>
    <AuthenticatedLayout>
        <div class="w-96 mx-auto pt-8">
            <div class="mb-8 flex items-center justify-between"> <!-- Добавлены flex и justify-between -->
                <div>
                    <h1>Изменить проект</h1>
                </div>
                <div class="ml-auto block"> <!-- или просто удалите ml-auto, т.к. justify-between уже выравнивает -->
                    <Link :href="route('project.index')" class="hover:bg-white hover:text-sky-500">Назад</Link>
                </div>
            </div>
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
