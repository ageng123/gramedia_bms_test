<template>
  <q-page class="q-pa-md">
    <h2 style="font-size: 24px; line-height: 1rem">Master Data : Buku</h2>
    <tableCustom
      :url="urlData"
      :columns="columns"
      @editRow="editRow"
      @deleteRow="deleteRow"
      @addRow="addRow"
    ></tableCustom>
  </q-page>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import { useQuasar } from 'quasar';
import tableCustom from 'components/Table.vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
export default defineComponent({
  name: 'books_index_page',
  components: { tableCustom },
  methods: {
    editRow(props: any) {
      let { id } = props;
      this.$router.push('/admin/books/edit/' + id);
    },
    deleteRow(props: any) {
      let { row, callback } = props;
      let { judul, id } = row;

      this.q.notify({
        message: 'Anda Yakin ingin menghapus data : ' + judul,
        position: 'center',
        actions: [
          {
            label: 'Ya, Saya Yakin',
            color: 'green',
            handler: () => {
              let data = new FormData();
              data.append('_method', 'DELETE');
              axios
                .delete(
                  'http://localhost:8000/api/book/' + id + '?_method=DELETE',
                  {
                    headers: { 'Content-Type': 'application/json' },
                  }
                )
                .then((resp) => {
                  this.q.notify('success!');
                  callback();
                });
            },
          },
          { label: 'no', color: 'red' },
        ],
      });
    },
    addRow(props: any) {
      this.$router.push('/admin/books/add');
    },
  },
  setup() {
    let urlData = 'http://localhost:8000/api/book';
    let q = useQuasar();
    let columns = [
      {
        name: 'judul',
        align: 'center',
        label: 'Judul Buku',
        field: 'judul',
        sortable: true,
      },
      {
        name: 'stok',
        align: 'center',
        label: 'Stock Buku',
        field: 'stok',
        sortable: true,
      },
      {
        name: 'action',
        align: 'center',
        label: 'Action',
        field: '',
        sortable: false,
      },
    ];
    return { urlData, columns, q };
  },
});
</script>
