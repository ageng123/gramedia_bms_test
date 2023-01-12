<template>
  <q-page class="q-pa-md">
    <h2 style="font-size: 1.5rem; line-height: 1rem">Edit Data Buku</h2>
    <BookForm
      @submit="submitHandler"
      @getData="getDataHandler"
      :id="id"
      :data="data"
    />
  </q-page>
</template>
<script lang="ts">
import { defineComponent, ref } from 'vue';
import { useRoute } from 'vue-router';
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
        if (i == 'gambar' && form[i].length != 0) {
          postData.append(i, form[i]);
        } else if (i != 'gambar') {
          postData.append(i, form[i]);
        }
      }
      console.log(postData);
      postData.append('_method', 'PUT');
      await axios
        .post(
          'http://localhost:8000/api/book/' + this.id + '?_method=PUT',
          postData,
          {
            headers: {
              'Content-Type': 'multipart/form-data',
              accept: 'application/json',
            },
          }
        )
        .then((resp) => {
          this.quasar.notify('Success Update Data');
          this.$router.push({ path: '/admin/books' });
        });
    },
    async getDataHandler(props: any) {
      await axios
        .get('http://localhost:8000/api/book/' + this.id)
        .then((resp) => {
          this.data = resp.data.data;
        });
      props(this.data);
      return this.data;
    },
    getId() {
      return this.$route.params.id;
    },
  },
  setup() {
    const route = useRoute();
    const id = ref(route.params.id);
    const data = ref({});
    const quasar = useQuasar();
    return { id, data, quasar };
  },

  mounted() {
    // this.getDataHandler(this.id);
  },
});
</script>
