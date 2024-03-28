<template>
  <div v-show="loading">
    <heart-beat-loader />
  </div>
  <div v-show="!loading">
    <authenticated-app v-if="auth.loggedIn"/>
    <un-authenticated-app v-if="!auth.loggedIn"/>
  </div>
</template>
<script setup>
import { onMounted, ref } from 'vue';
import AuthenticatedApp from './Bein-Assignment/AuthenticatedApp.vue';
import UnAuthenticatedApp from './Bein-Assignment/UnAuthenticatedApp.vue';
import HeartBeatLoader from './Bein-Assignment/components/loaders/heartbeatloader.vue'
import useAuth from './Bein-Assignment/stores/auth';

const auth = useAuth();
const loading = ref(true);

onMounted(async () => {
  await auth.refresh();
  loading.value = false;
})

</script>