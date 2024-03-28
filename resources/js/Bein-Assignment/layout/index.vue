<script setup lang="ts">
  import SideBar from './partials/sidebar.vue';
  import NavBar from './partials/navbar.vue';
  import useSnack from '../stores/snackbar';
  import classes from '@/css/libs/index.css';

  const snackbar = useSnack(); 
</script>

<template>
  <v-layout :class="classes.app_font">
    <side-bar />
    <v-main style="min-height: 100svh;"> 
      <nav-bar />
      <div>
        <slot /> 
      </div>
    </v-main >


    <v-snackbar v-model="snackbar.success" color="success" :timeout="snackbar.timeout" :location="snackbar.location">
      {{snackbar.message ? snackbar.message : 'Operation Success'}}
      <template v-slot:actions>
        <v-btn @click="snackbar.closeSuccessSnackbar">
          Close
        </v-btn>
      </template>
    </v-snackbar>

    <v-snackbar v-model="snackbar.error" color="error" :timeout="snackbar.timeout" :location="snackbar.location">
      {{snackbar.message ? snackbar.message : 'Server Error'}}
      <template v-slot:actions>
        <v-btn color="red" variant="text" @click="snackbar.closeErrorSnackbar">
          Close
        </v-btn>
      </template>
    </v-snackbar>

  </v-layout>
</template>