<script setup lang="ts">
  import useAuth from "@/stores/auth";
  defineProps<{permission:string}>();
  const auth = useAuth();
</script>
<template>
  <div v-show="auth.can(permission)">
    <slot></slot>      
  </div>
</template>