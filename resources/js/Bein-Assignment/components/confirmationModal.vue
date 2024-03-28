<script setup lang="ts">
  defineProps<{modelValue:any, loading?:boolean}>();
  const emit = defineEmits();
</script>

<template>
  <v-dialog :model-value="modelValue" transition="dialog-bottom-transition" width="600">
    <v-card class="pa-4">
      <v-card-title>
        Are you sure?
      </v-card-title>
      <div class="d-flex ga-2 mt-6">
        <v-btn type="submit" class="bg-error" :loading="loading" @click="emit('deleted')">delete</v-btn>
        <v-btn type="button" @click="emit('update:model-value', false)">cancel</v-btn>
      </div>
    </v-card>    
  </v-dialog>
</template>