<script setup lang="ts">
  import axios from 'axios';
  import useQuery from '@/hooks/useQuery';
  import useMutation from '@/hooks/useMutation';

  const emit = defineEmits();

  const {type, returnObject} = defineProps<{
    name: string
    label: string
    type: string
    errors: any
    variant: "filled" | "outlined" | "plain" | "underlined" | "solo" | "solo-inverted" | "solo-filled" | undefined
    returnObject: boolean
  }>();

  const {data:suggestions, refetch} = useQuery(
    () => axios.get(`/api/suggestions/list?type=${type}`), {enabled:false}
  );

  const {mutate, loading:suggestionLoading} = useMutation(
    (data) => axios.post('/api/suggestions', data),
    {
      onSuccess:(response) => {
        refetch();
        emit('update:model-value', response.data.data.content);
      }
    }
  );

  const handleSuggestionCreation = async (event) => {
    if(suggestions.value.some(_ => _.content === event.target.value)) return;
    mutate({content: event.target.value, type});
  }

</script>
<template>
  <v-autocomplete 
    item-title="content"
    :label="label"
    :items="suggestions"
    :error="!!errors?.[name]"
    :error-messages="errors?.[name]"
    :loading="suggestionLoading"
    :return-object="returnObject"
    @update:model-value="e => emit('update:model-value', e)"
    @update:focused="refetch"
    @keydown.enter="handleSuggestionCreation"
    :variant="variant"
  >
    <template #no-data>
      <v-item-list class="my-1 mx-4 py-2">
        press enter for creation
      </v-item-list>
    </template>
  </v-autocomplete>
</template>