<script setup lang="ts">
  import { onMounted } from 'vue';
  import useQuery from '@/hooks/useQuery'
  import axios  from 'axios';

  const {data, loading} = useQuery(() => axios.get('/api/countries'));
  const emit = defineEmits();
  const model = defineModel({default:'Iraq'});
  defineProps<{error: boolean, errorMessages: string| string[]}>();
  onMounted(() => emit('update:model-value', "Iraq"))
</script>

<template> 
  <v-autocomplete 
    v-model="model"
    label="Country"
    variant="outlined"
    item-title="name"
    :loading="loading"
    :items="data"
    item-value="name"
    :error-messages="errorMessages"
    :error="error"
  >
    <template v-slot:item="{ props, item }">
      <v-list-item v-bind="props" :prepend-avatar="item.raw.url" :title="item.raw.name" />
    </template>
  </v-autocomplete>
</template>