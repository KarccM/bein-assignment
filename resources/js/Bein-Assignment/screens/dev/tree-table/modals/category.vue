<script setup lang="ts">
  import {ref} from 'vue';
  import axios from 'axios';
  import zod from 'zod';
  import useMutation from '@/hooks/useMutation';
  import Category from '@/types/category';

  const emit = defineEmits();
  const {parent, closeModal, category} = defineProps<{ parent?: Category,category?: Category, closeModal: Function}>();
  const formErrors = ref();
  const form = ref({...category});
  const schema = zod.object({ name: zod.string() });

  const {mutate, loading, errors} = useMutation(
    () => axios({
      url: form.value.id ? `/api/categories/${form.value.id}`: `/api/categories`, 
      data: {...form.value, parentId: parent?.id},
      method: form.value.id? 'PUT' : 'POST',
    }),
    {
      onSuccess:() => { 
        emit('refetch'); 
        handleModalClose();
      },
    }
  );
  
  const handleModalClose = () => {
    form.value = {};
    closeModal();
  }

  const handleSubmit = async() => {
    const result = schema.safeParse(form.value);    
    if(!result.success) {
      formErrors.value = result.error?.format() ?? {};
      return;
    }
    mutate();
  }

</script>

<template>
 <v-form @submit.prevent="handleSubmit">
    <div class="text-h5 mb-4">{{ category?.id ? 'Edit' : 'Add New' }} Category</div>
    <v-alert class="mb-4" v-if="errors?.parentId" color="error">{{ errors?.parentId[0] }}</v-alert>
    <v-text-field label="Name"  :error="!!formErrors?.name" :error-messages="formErrors?.name?._errors" v-model="form.name" />
    <div class="d-flex ga-2 mt-6">
      <v-btn type="submit" class="bg-primary" :loading="loading">submit</v-btn>
      <v-btn type="button" @click="handleModalClose">cancel</v-btn>
    </div>
  </v-form>
</template>