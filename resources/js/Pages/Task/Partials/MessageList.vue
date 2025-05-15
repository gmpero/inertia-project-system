<!--<template>-->
<!--  <div class="bg-white rounded-lg shadow overflow-hidden">-->
<!--    <h3 class="px-6 py-4 bg-gray-50 text-lg font-medium">Сообщения</h3>-->
<!--    <div class="divide-y divide-gray-200">-->
<!--      <div v-for="message in messages" :key="message.id" class="p-6 group relative">-->
<!--        &lt;!&ndash; Кнопки действий (появляются при наведении) &ndash;&gt;-->
<!--        <div class="absolute top-4 right-4 flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">-->
<!--          &lt;!&ndash; Кнопка редактирования (карандашик) &ndash;&gt;-->
<!--          <button-->
<!--              @click="openEditModal(message)"-->
<!--              class="text-gray-400 hover:text-blue-500 transition-colors"-->
<!--              title="Редактировать"-->
<!--          >-->
<!--            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"-->
<!--                 stroke="currentColor">-->
<!--              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"-->
<!--                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>-->
<!--            </svg>-->
<!--          </button>-->

<!--          &lt;!&ndash; Кнопка удаления (мусорка) &ndash;&gt;-->
<!--          <button-->
<!--              @click="deleteMessage(message)"-->
<!--              class="text-gray-400 hover:text-red-500 transition-colors"-->
<!--              title="Удалить"-->
<!--          >-->
<!--            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"-->
<!--                 stroke="currentColor">-->
<!--              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"-->
<!--                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>-->
<!--            </svg>-->
<!--          </button>-->
<!--        </div>-->

<!--        <div class="flex justify-between items-start mb-2">-->
<!--          <span class="text-sm text-gray-500">{{ formatDate(message.created_at) }}</span>-->
<!--        </div>-->
<!--        <p class="text-gray-700" v-html="message.message"></p>-->
<!--      </div>-->
<!--    </div>-->

<!--    &lt;!&ndash; Модальное окно редактирования &ndash;&gt;-->
<!--    <div v-if="showEditModal" class="fixed inset-0 z-50 overflow-y-auto">-->
<!--      <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">-->
<!--        &lt;!&ndash; Фон &ndash;&gt;-->
<!--        <div class="fixed inset-0 transition-opacity" aria-hidden="true">-->
<!--          <div class="absolute inset-0 bg-gray-500 opacity-75" @click="closeEditModal"></div>-->
<!--        </div>-->

<!--        &lt;!&ndash; Центрирование модального окна &ndash;&gt;-->
<!--        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>-->

<!--        &lt;!&ndash; Само модальное окно &ndash;&gt;-->
<!--        <div-->
<!--            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">-->
<!--          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">-->
<!--            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">-->
<!--              Редактирование сообщения-->
<!--            </h3>-->
<!--            <textarea-->
<!--                v-model="editingMessage.message"-->
<!--                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"-->
<!--                rows="4"-->
<!--            ></textarea>-->
<!--          </div>-->
<!--          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">-->
<!--            <button-->
<!--                type="button"-->
<!--                @click="saveEditedMessage"-->
<!--                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"-->
<!--            >-->
<!--              Сохранить-->
<!--            </button>-->
<!--            <button-->
<!--                type="button"-->
<!--                @click="closeEditModal"-->
<!--                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"-->
<!--            >-->
<!--              Отмена-->
<!--            </button>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--</template>-->

<!--<script>-->
<!--export default {-->
<!--  name: "MessageList",-->

<!--  props: {-->
<!--    messages: {-->
<!--      type: Array,-->
<!--      required: true,-->
<!--      default: () => []-->
<!--    }-->
<!--  },-->

<!--  data() {-->
<!--    return {-->
<!--      showEditModal: false,-->
<!--      editingMessage: {-->
<!--        id: null,-->
<!--        message: ''-->
<!--      }-->
<!--    }-->
<!--  },-->

<!--  methods: {-->
<!--    formatDate(dateString) {-->
<!--      const options = {day: 'numeric', month: 'long', year: 'numeric'};-->
<!--      return new Date(dateString).toLocaleDateString('ru-RU', options);-->
<!--    },-->

<!--    openEditModal(message) {-->
<!--      this.editingMessage = {-->
<!--        id: message.id,-->
<!--        message: message.message-->
<!--      };-->
<!--      this.showEditModal = true;-->
<!--    },-->

<!--    closeEditModal() {-->
<!--      this.showEditModal = false;-->
<!--    },-->

<!--    saveEditedMessage() {-->
<!--      this.$inertia.patch(route('message.update', this.editingMessage.id), {-->
<!--        message: this.editingMessage.message,-->
<!--      }, {-->
<!--        preserveScroll: true,-->
<!--        onSuccess: () => {-->
<!--          this.closeEditModal();-->
<!--          this.$toast.success('Сообщение успешно обновлено');-->
<!--        },-->
<!--        onError: (errors) => {-->
<!--          this.$toast.error('Ошибка при обновлении сообщения');-->
<!--          if (errors) {-->
<!--            console.error(errors);-->
<!--          }-->
<!--        }-->
<!--      });-->
<!--    },-->

<!--    deleteMessage(message) {-->
<!--      if (confirm('Вы уверены, что хотите удалить это сообщение?')) {-->
<!--        this.$inertia.delete(route('message.delete', message.id), {-->
<!--          preserveScroll: true,-->
<!--          onSuccess: () => {-->
<!--            this.$toast.success('Сообщение удалено');-->
<!--          },-->
<!--          onError: () => {-->
<!--            this.$toast.error('Ошибка при удалении');-->
<!--          }-->
<!--        });-->
<!--      }-->
<!--    }-->
<!--  }-->
<!--}-->
<!--</script>-->

<!--<style scoped>-->
<!--/* Плавное появление кнопок при наведении */-->
<!--.group:hover .group-hover\:opacity-100 {-->
<!--  opacity: 1;-->
<!--}-->
<!--</style>-->


<template>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <h3 class="px-6 py-4 bg-gray-50 text-lg font-medium">Сообщения</h3>
    <div class="divide-y divide-gray-200">
      <div v-for="message in messages" :key="message.id" class="p-6 group relative">
        <!-- Кнопки действий -->
        <div class="absolute top-4 right-4 flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
          <button
              @click="openEditModal(message)"
              class="text-gray-400 hover:text-blue-500 transition-colors"
              title="Редактировать"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
          </button>

          <button
              @click="deleteMessage(message)"
              class="text-gray-400 hover:text-red-500 transition-colors"
              title="Удалить"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
          </button>
        </div>

        <div class="flex justify-between items-start mb-2">
          <span class="text-sm text-gray-500">{{ formatDate(message.created_at) }}</span>
        </div>
        <div class="text-gray-700" v-html="message.message"></div>
      </div>
    </div>

    <!-- Модальное окно редактирования -->
    <div v-if="showEditModal" class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75" @click="closeEditModal"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
              Редактирование сообщения
            </h3>

            <!-- Контейнер для Quill Editor -->
            <div ref="editorContainer" class="ql-editor-container"></div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button
                type="button"
                @click="saveEditedMessage"
                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
            >
              Сохранить
            </button>
            <button
                type="button"
                @click="closeEditModal"
                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
            >
              Отмена
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "MessageList",

  props: {
    messages: {
      type: Array,
      required: true,
      default: () => []
    }
  },

  data() {
    return {
      showEditModal: false,
      editingMessage: {
        id: null,
        content: ''
      },
      quillInstance: null // Переименовали для ясности
    }
  },

  methods: {
    formatDate(dateString) {
      const options = {day: 'numeric', month: 'long', year: 'numeric'};
      return new Date(dateString).toLocaleDateString('ru-RU', options);
    },

    openEditModal(message) {
      this.editingMessage = {
        id: message.id,
        content: message.message
      };
      this.showEditModal = true;

      this.$nextTick(() => {
        // Очищаем предыдущий экземпляр
        if (this.quillInstance) {
          this.quillInstance.off('text-change');
          try {
            this.quillInstance.destroy();
          } catch (e) {
            console.warn('Error destroying Quill instance:', e);
          }
          this.quillInstance = null;
        }

        // Создаем новый экземпляр
        this.quillInstance = new Quill(this.$refs.editorContainer, {
          theme: 'snow',
          modules: {
            toolbar: [
              ['bold', 'italic', 'underline'],
              [{ 'list': 'ordered'}, { 'list': 'bullet' }],
              ['link'],
              ['clean']
            ]
          }
        });

        // Устанавливаем содержимое
        this.quillInstance.root.innerHTML = this.editingMessage.content;

        // Обновляем содержимое при изменении
        this.quillInstance.on('text-change', () => {
          this.editingMessage.content = this.quillInstance.root.innerHTML;
        });
      });
    },

    closeEditModal() {
      if (this.quillInstance) {
        this.quillInstance.off('text-change');
        try {
          this.quillInstance.destroy();
        } catch (e) {
          console.warn('Error destroying Quill instance:', e);
        }
        this.quillInstance = null;
      }
      this.showEditModal = false;
    },

    saveEditedMessage() {
      if (!this.quillInstance) return;

      const htmlContent = this.quillInstance.root.innerHTML;

      this.$inertia.patch(route('message.update', this.editingMessage.id), {
        message: htmlContent,
      }, {
        preserveScroll: true,
        onSuccess: () => {
          this.closeEditModal();
          this.$toast.success('Сообщение успешно обновлено');
        },
        onError: (errors) => {
          this.$toast.error('Ошибка при обновлении сообщения');
          if (errors) {
            console.error(errors);
          }
        }
      });
    },

    deleteMessage(message) {
      if (confirm('Вы уверены, что хотите удалить это сообщение?')) {
        this.$inertia.delete(route('message.delete', message.id), {
          preserveScroll: true,
          onSuccess: () => {
            this.$toast.success('Сообщение удалено');
          },
          onError: () => {
            this.$toast.error('Ошибка при удалении');
          }
        });
      }
    }
  },

  beforeUnmount() {
    if (this.quillInstance) {
      this.quillInstance.off('text-change');
      try {
        this.quillInstance.destroy();
      } catch (e) {
        console.warn('Error destroying Quill instance:', e);
      }
    }
  }
}
</script>

<style>
/* Стили для Quill Editor */
.ql-editor-container {
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  height: 300px;
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
  min-height: 250px;
}

/* Стили для кнопок действий */
.group:hover .group-hover\:opacity-100 {
  opacity: 1;
}
</style>

