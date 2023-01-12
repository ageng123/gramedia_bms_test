<template>
  <q-page class="q-pa-md">
    <h2 style="font-size: 24px; line-height: 1rem">Master Data : User</h2>
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
  name: 'user_index_page',
  components: { tableCustom },
  methods: {
    editRow(props: any) {
      let { id } = props;
      this.$router.push('/admin/users/edit/' + id);
    },
    deleteRow(props: any) {
      let { row, callback } = props;
      let { email, id } = row;

      this.q.notify({
        message: 'Anda Yakin ingin menghapus data : ' + email,
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
                  'http://localhost:8000/api/users/' + id + '?_method=DELETE',
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
      this.$router.push('/admin/users/add');
    },
  },
  setup() {
    let urlData = 'http://localhost:8000/api/users';
    let q = useQuasar();
    let columns = [
      {
        name: 'email',
        align: 'center',
        label: 'Email User',
        field: 'email',
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
