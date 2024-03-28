<template>
  <v-breadcrumbs :items="breadcrumbsItems" class="px-0"/>
</template>

<script setup lang="ts">
import { useRoute } from 'vue-router';
interface BreadcrumbsItems {
  title: any; 
  href: string;
  disabled?: boolean;
}
const route = useRoute()
const breadcrumbsItems: BreadcrumbsItems[] = route.matched
  .map(_ => ({title:_.meta.title, href:_.path}))
  .filter(_ => _.title); 
</script>