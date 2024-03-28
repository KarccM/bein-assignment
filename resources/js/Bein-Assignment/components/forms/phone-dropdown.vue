<script setup lang="ts">
  import axios from 'axios';
  import useQuery from '@/hooks/useQuery';
  import {watch} from 'vue';
  defineProps<{error: boolean, errorMessages: string| string[]}>();
  const emit = defineEmits();
  const model = defineModel();
  const {data, refetch} = useQuery(
    () => axios.get(`/api/patients?phone=${model.value ?? ''}`),
  );
  watch(model, model => typeof(model) === 'object' && emit('patientFound', model));
</script>
<template>
  <v-combobox
    v-model="model"
    label="Phone"
    @update:search="refetch"
    item-title="phone"
    :items="data"
    :error-messages="errorMessages"
    :error="error"
  >
    <template v-slot:item="{ props, item }">
      <v-list-item v-bind="props" :title="item.raw.phone" :value="item.raw.phone" :subtitle="item.raw.fullName" />
    </template>
  </v-combobox>
</template>