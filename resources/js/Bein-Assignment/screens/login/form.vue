<script setup>
import { ref } from 'vue';
import zod from 'zod'
import useAuth from '../../stores/auth'

const auth = useAuth();

const formSchema = zod.object({ username: zod.string().min(3), password: zod.string().min(6)});

const form = ref({ username: '', password: '' });
const errors = ref({});

const submit = () => {
  const result = formSchema.safeParse(form.value);
  errors.value = result.error?.format() ?? {};

  if (result.success) {
    axios.get('/sanctum/csrf-cookie').then(() => {
      axios.post('/api/login', form.value)
      .then(({data}) => auth.$state = {user:data.data, loggedIn: true})
      .catch((formErrors) => errors.value = {username: {_errors : formErrors.response.data.username}});
    });
  }
};
const onClear = () => console.log('cleared');
</script>

<template>
  <v-card class="w-50 pa-8 mt-4" elevation="4">
    <v-alert title="Note" type="info" variant="tonal">
      <p>username: master</p>
      <p>password: Master.1234</p>
    </v-alert>
    <p color="blue-lighten-1" class="text-h3 text-center my-4">Login Form</p>
    <v-form @submit.prevent="submit">
      <v-text-field
        clearable
        label="username"
        persistent-clear
        @click:clear="onClear"
        variant="underlined"
        v-model="form.username"
        :error="!!errors.username"
        :error-messages="errors.username?._errors"
      />
      <v-text-field
        clearable
        label="password"
        type="password"
        persistent-clear
        @click:clear="onClear"
        variant="underlined"
        v-model="form.password"
        :error="!!errors.password"
        :error-messages="errors.password?._errors"
      />
      <v-btn class="mt-8" type="submit" block color="blue-lighten-1">Login</v-btn>
    </v-form>
  </v-card>
</template>