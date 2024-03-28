<script setup lang="ts">
import Profile from './profile.vue';
</script>

<template>
  <v-app-bar :elevation="1">
    <div class="d-flex w-100 justify-end px-10">
      <Profile />
    </div>
  </v-app-bar>
</template>