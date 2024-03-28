<script setup lang="ts">
  import { useRoute } from 'vue-router';
  import Breadcrumb from '../components/breadcrumb.vue';
  import Authorize from '../components/pageAuthorizer.vue';
  
  const route = useRoute();
  defineProps<{permission:string}>();
</script>

<template>
  <div class="ma-4">
    <div class="d-flex justify-space-between align-center my-2">
      <div>
        <div class="text-h3 font-weight-medium">{{ route.meta.title }}</div> 
        <Breadcrumb />
      </div>
      <slot name="button"/>
    </div>
    <Authorize :permission="permission">
        <slot />
    </Authorize>
  </div>
</template>