<script setup lang="ts">
  const model = defineModel()
  defineProps<{loading?:boolean}>();
  const emit = defineEmits();
</script>

<template>
  <v-dialog v-model="model" transition="dialog-bottom-transition" width="600">
    <v-card class="pa-4">
      <v-card-title>
        Are you sure?
      </v-card-title>
      <v-card-text>
        You won't be able to revert this!
      </v-card-text>
      <div class="d-flex ga-2 mt-6">
        <v-btn type="submit" class="bg-error" :loading="loading" @click="emit('deleted')">delete</v-btn>
        <v-btn type="button" @click="model = false">cancel</v-btn>
      </div>
    </v-card>    
  </v-dialog>
</template>