<script setup lang="ts">
  import useAuth from "../stores/auth";
  defineProps<{permission:string}>();
  const auth = useAuth();
</script>
<template>
  <div v-show="auth.can(permission)">
    <slot></slot>      
  </div>

  <div v-show="!auth.can(permission)">
    <div style="display: grid;place-items: center;">
      <div class="text-center pa-16 text-grey">
        <p class="text-h1">403</p>
        <p class="text-h5">Page UnAuthorize</p>
      </div>
    </div>      
  </div>
</template>