<script setup lang="ts">
  defineProps<{path:string}>()
  const emit = defineEmits();
  const model = defineModel()
</script>
<template>
  <v-dialog v-model="model">
    <v-card class="mx-auto" v-click-outside="() => emit('update:model-value', false)">
      <v-img aspect-ratio="16/9"  :src="path" max-height="800" :width="800"/>
    </v-card>
  </v-dialog>
</template>