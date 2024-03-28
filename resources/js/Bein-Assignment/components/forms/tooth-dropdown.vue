<script setup lang="ts">
import axios from 'axios';
import { ref } from 'vue';
import Treatment from '../../types/treatment';
import Procedure from '../../types/procedure';

const emit = defineEmits();

const props = defineProps({
  label: String,
  returnObject: { type: Boolean, default: false},
  error: Boolean,
  errorMessages: Array,
  modelValue: Array,
});

const items = ref<any []>();

const fetch = async () => {
  const {data} = await axios.get(`/api/procedures?type=general`);
  items.value = data.data.map((item:Procedure) => {
    
    let treatment = props.modelValue?.find((_:Treatment) => _.procedureId === item.id);

    if(treatment) return {...item, state:treatment.state};
    
    return item;
  });
}

function getColor(state:string) {
  if(state === 'in-progress') return 'warning';
  if(state === 'failed') return 'error';
  if(state === 'done') return 'success';
  return '';
}
</script>

<template>
  <v-select
    :label="label"
    :items="items"
    :error="error"
    :error-messages="errorMessages"
    :return-object="true"
    :model-value="modelValue"
    @update:focused="fetch"
    @update:model-value="e => emit('update:model-value', e)"
    item-title="name"
    item-value="id"
    multiple
    hide-details
    variant="underlined"
  >
    <template v-slot:selection="{ item, index }">
      <p class="v-select__selection-text" v-show="index === 0">{{ item.raw.name }} </p>
    </template>

    <template v-slot:item="{ props, item }">
      <v-list-item
        v-bind="props"
        :title="item.raw.name"
        :color="getColor(item.raw.state)"
      ></v-list-item>
    </template>
  </v-select>
</template>