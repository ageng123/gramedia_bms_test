<template>
  <div
    class="q-pa-md justify-center text-center"
    style="
      height: 100%;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      padding: 1rem 1.2rem;
    "
  >
    <h1 style="font-size: 18px; font-weight: bold">Login Form</h1>
    <q-input
      color="blue-12"
      label="E-mail"
      v-model="form.email"
      :error="errors.email != ''"
    >
      <template v-slot:prepend>
        <q-icon name="person" />
      </template>
      <template v-slot:error> {{ errors.email }} </template>
    </q-input>
    <q-input
      color="blue-12"
      :type="passwordType"
      label="Password"
      v-model="form.password"
      :error="errors.password != ''"
    >
      <template v-slot:prepend>
        <q-icon name="lock" />
      </template>
      <template v-slot:append>
        <q-btn flat @click="handleShowPasswordButton()">
          <q-icon
            :name="passwordType == 'password' ? 'visibility' : 'visibility_off'"
          />
        </q-btn>
      </template>
      <template v-slot:error> {{ errors.password }}</template>
    </q-input>
    <q-btn
      :loading="progress"
      style="margin-top: 1rem; width: 100%"
      color="primary"
      label="Sign In"
      @click="handleSignInButton(true)"
    >
      <template v-slot:loading>
        <q-spinner-oval class="on-left" />
        Please Wait
      </template>
    </q-btn>
    <q-btn
      flat
      color="standar"
      style="margin-top: 1rem; width: 100%"
      label="Don't Have Account Yet ? Sign Up Here"
    />
  </div>
</template>
<script lang="ts">
import { defineComponent, ref } from 'vue';
import axios from 'axios';
import { useQuasar } from 'quasar';
import { useRouter } from 'vue-router';
export default defineComponent({
  name: 'login-form',
  preFetch({ redirect }) {
    if (localStorage.getItem('token') != undefined) {
      redirect({ path: '/admin/books' });
    }
  },
  setup() {
    const progress = ref(false),
      passwordType = ref('password'),
      form = ref({
        email: '',
        password: '',
      });
    let errors = ref({
      email: '',
      password: '',
    });
    const router = useRouter();
    const $q = useQuasar();
    const handleSignInButton = async (status = false) => {
      progress.value = status;
      let formData = new FormData();
      for (let i in form.value) {
        formData.append(i, form.value[i]);
      }
      formData.append('form_type', 'login');
      await axios({
        method: 'POST',
        url: 'http://localhost:8000/api/auth/login',
        data: formData,
        responseType: 'json',
      }).then(
        (resp) => {
          localStorage.setItem('token', resp.data.data.token);
          $q.notify({
            color: 'green',
            message: 'Successfully Login',
            type: 'positive',
            position: 'center',
          });
          router.push({ path: '/dashboard' });
        },
        (err) => {
          let errorResponse = err.response.data.errors;
          if (typeof errorResponse == 'object') {
            for (let i in errorResponse) {
              errors.value[i] = errorResponse[i].join(',');
            }
          }
          if (typeof errorResponse == 'string') {
            errors.value.email = errorResponse;
          }
        }
      );

      progress.value = false;
    };
    const handleShowPasswordButton = () => {
      console.log();
      if (passwordType.value == 'password') {
        passwordType.value = 'text';
        return;
      }
      if (passwordType.value == 'text') {
        passwordType.value = 'password';
        return;
      }
    };
    return {
      progress,
      handleSignInButton,
      handleShowPasswordButton,
      passwordType,
      form,
      errors,
    };
  },
});
</script>
