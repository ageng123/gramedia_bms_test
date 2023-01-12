<template>
  <q-form>
    <q-input v-model="form.judul" label="Judul Buku"></q-input>
    <q-input v-model="form.stok" type="number" label="Stock Buku"></q-input>
    <q-file v-model="form.gambar" label="Gambar Buku"></q-file>
    <q-img :src="gambar"></q-img>
    <q-btn
      color="primary"
      @click="submitHandler"
      style="width: 100%; margin-top: 1rem"
      >Submit</q-btn
    >
  </q-form>
</template>
<script lang="ts">
import { defineComponent, ref, PropType } from 'vue';
interface Buku {
  judul: string;
  stok: number;
  gambar: any[];
}
export default defineComponent({
  name: 'BookForm',
  props: {
    id: {
      type: Number,
      default: 0,
    },
    data: {
      type: Object as PropType<Buku>,
    },
  },
  methods: {
    async submitHandler() {
      this.$emit('submit', this.form);
    },
    async getDataForm() {
      this.$emit('getData', (resp: any) => this.setFormData(resp));
    },
  },
  setup() {
    const form = ref<Buku>({
      judul: '',
      stok: 0,
      gambar: [],
    });
    const gambar = ref('');
    function setFormData(resp: any) {
      form.value.judul = resp.judul;
      form.value.stok = resp.stok;
      form.value.gambar = [];
      gambar.value = 'http://localhost:8000/' + resp.gambar;
      return;
    }
    return { form, setFormData, gambar };
  },
  preFetch() {
    console.log(this.id);
    if (this.id != 0) {
      this.getDataForm();
    }
  },
  mounted() {
    this.getDataForm();
    this.$emit('getData', (resp: any) => this.setFormData);
  },
});
</script>
