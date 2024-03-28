<script setup lang="ts">
import axios from 'axios';
import { ref } from 'vue';

const emit = defineEmits();

const props = defineProps({
  url: String,
  label: String,
  returnObject: { type: Boolean, default: false},
  title: { type: String, default: 'name'},
  value: { type: String, default: 'id'},
  variant: {type: String, default: 'filled'},
  error: Boolean,
  errorMessages: Array,
});

const items = ref<any []>();

const fetch = async () => {
  const {data} = await axios.get(`/api/${props.url}`);
  items.value = data.data;
}
</script>

<template>
  <v-autocomplete
    @update:focused="fetch"
    @update:model-value="e => emit('update:model-value', e)"
    :label="label"
    :item-title="title"
    :item-value="value"
    :return-object="returnObject"
    :items="items"
    :variant="variant"
    :error="error"
    :error-messages="errorMessages"
  >
    <slot name="item"/>
  </v-autocomplete>
</template>