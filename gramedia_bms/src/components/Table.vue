<template>
  <q-table
    ref="tableRef"
    title=""
    :rows="serverData"
    :columns="columnsTable"
    row-key="id"
    v-model:pagination="pagination"
    :loading="loading"
    :filter="filter"
    binary-state-sort
    @request="paginationHandler"
  >
    <template v-slot:top-right>
      <q-input dense debounce="300" v-model="query" placeholder="Search">
        <template v-slot:append>
          <q-icon name="search" />
        </template>
      </q-input>
    </template>
    <template v-slot:top-left>
      <q-btn color="primary" icon="add" @click="addRow()"> Add Data</q-btn>
    </template>
    <template v-slot:body-cell-action="props">
      <q-td :props="props">
        <q-btn
          dense
          round
          flat
          color="grey"
          @click="editRow(props)"
          icon="edit"
        ></q-btn>
        <q-btn
          dense
          round
          flat
          color="grey"
          @click="deleteRow(props)"
          icon="delete"
        ></q-btn>
      </q-td>
    </template>
  </q-table>
</template>
<script lang="ts">
import { defineComponent, ref } from 'vue';
import axios from 'axios';
export default defineComponent({
  name: 'tableCustom',
  props: {
    url: {
      type: String,
      default: '',
    },
    columns: {
      type: Array,
      default: null,
    },
  },
  data() {
    return {
      filter: '',
      loading: false,
      columnsTable: [],
    };
  },
  methods: {
    editRow({ row }: any) {
      this.$emit('editRow', row);
    },
    deleteRow({ row }: any) {
      this.$emit('deleteRow', {
        row: row,
        callback: () => this.getServerData(this.url),
      });
    },
    addRow(props: any) {
      this.$emit('addRow', props);
    },
    async paginationHandler(props: any) {
      console.log(props);
      this.loading = true;
      this.pagination.rowsPerPage = props.pagination.rowsPerPage;
      this.getServerData(this.url);
      this.loading = false;
    },
  },
  setup() {
    const serverData = ref([]);
    const query = ref('');
    const pagination = ref({
      sortBy: 'desc',
      descending: false,
      page: 1,
      rowsPerPage: 10,
      rowsNumber: 10,
    });
    async function getServerData(url: any) {
      console.log(url);
      let data: never[] = [];
      await axios
        .get(url, {
          params: {
            limit: pagination.value.rowsPerPage,
            page: pagination.value.page,
            q: query.value,
          },
        })
        .then((resp) => {
          console.log(resp);
          data = resp.data.data;
        });
      pagination.value.rowsNumber = data.length;
      serverData.value = data;
      console.log(serverData.value);
    }

    return { getServerData, serverData, pagination, query };
  },
  async mounted() {
    this.loading = true;
    this.columnsTable = this.columns;
    await this.getServerData(this.url);
    this.loading = false;
  },
});
</script>
