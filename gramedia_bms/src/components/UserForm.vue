<template>
  <q-form>
    <q-input v-model="form.email" label="Email"></q-input>
    <q-input v-model="form.password" type="password" label="Password"></q-input>
    <q-input
      v-model="form.c_password"
      type="password"
      label="Confirm Password"
    ></q-input>

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
interface User {
  email: string;
  password: string;
  c_password: string;
}
export default defineComponent({
  name: 'UserForm',
  props: {
    id: {
      type: Number,
      default: 0,
    },
    data: {
      type: Object as PropType<User>,
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
    const form = ref<User>({
      email: '',
      password: '',
      c_password: '',
    });
    const gambar = ref('');
    function setFormData(resp: any) {
      form.value.email = resp.email;

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
