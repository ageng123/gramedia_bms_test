<template>
  <q-page class="q-pa-md">
    <h2 style="font-size: 1.5rem; line-height: 1rem">Tambah Data Buku</h2>
    <BookForm @submit="submitHandler" url="url" />
  </q-page>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import BookForm from 'components/BookForm.vue';
import axios from 'axios';
import { useQuasar } from 'quasar';
export default defineComponent({
  components: { BookForm },
  props: {
    url: {
      type: String,
      default: '',
    },
  },
  methods: {
    async submitHandler(form: any) {
      console.log(form);
      let postData = new FormData();
      for (let i in form) {
        postData.append(i, form[i]);
      }
      console.log(postData);
      await axios
        .post('http://localhost:8000/api/book', postData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })
        .then((resp) => {
          this.quasar.notify('Success add Data');
          this.$router.push({ path: '/admin/books' });
        });
    },
  },
  setup() {
    const quasar = useQuasar();
    return { quasar };
  },
});
</script>
