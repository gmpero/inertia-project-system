<template>
  <div class="bg-white rounded-lg shadow p-6">
    <form @submit.prevent="store">
      <!-- Контейнер для Quill Editor -->
      <div ref="editor" class="mb-4" style="height: 200px;"></div>

      <!-- Скрытое поле для формы -->
      <input type="hidden" name="message" v-model="messageHtml">

      <button
          type="submit"
          class="px-4 py-2 bg-sky-500 text-white rounded-md hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2"
      >
        Отправить
      </button>
    </form>
  </div>
</template>

<script>
import { Link, useForm } from '@inertiajs/vue3'

export default {
  name: "MessageForm",
  components: { Link },
  props: {
    taskId: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      task_id: this.taskId,
      messageHtml: '', // Здесь будет HTML содержимое
      quill: null // Ссылка на экземпляр Quill
    }
  },
  mounted() {
    // Инициализация Quill после монтирования компонента
    this.quill = new Quill(this.$refs.editor, {
      theme: 'snow',
      modules: {
        toolbar: [
          ['bold', 'italic', 'underline'],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          ['link'],
          ['clean']
        ]
      },
      placeholder: 'Введите ваше сообщение...'
    });

    // Обновляем messageHtml при изменении содержимого
    this.quill.on('text-change', () => {
      this.messageHtml = this.$refs.editor.querySelector('.ql-editor').innerHTML;
    });
  },
  beforeUnmount() {
    // Очистка при размонтировании компонента
    if (this.quill) {
      this.quill.off('text-change');
      this.quill = null;
    }
  },
  methods: {
    store() {
      this.$inertia.post(route('message.store'), {
        task_id: this.taskId,
        message: this.messageHtml, // Отправляем HTML содержимое
      }, {
        preserveScroll: true,
        onSuccess: () => {
          // Очищаем редактор после отправки
          this.quill.root.innerHTML = '';
          this.messageHtml = '';
        }
      });
    }
  }
}
</script>

<style>
/* Дополнительные стили для лучшего отображения */
.ql-container {
  border: 1px solid #d1d5db !important;
  border-radius: 0.375rem !important;
  font-family: inherit !important;
}

.ql-toolbar {
  border-top-left-radius: 0.375rem !important;
  border-top-right-radius: 0.375rem !important;
  border: 1px solid #d1d5db !important;
  border-bottom: none !important;
}
</style>
