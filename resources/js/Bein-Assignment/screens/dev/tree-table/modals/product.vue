<script setup lang="ts">
  import {ref} from 'vue';
  import axios from 'axios';
  import zod from 'zod';
  import useMutation from '../../../../hooks/useMutation';
  import Product from '../../../../types/product';
  import Category from '../../../../types/category';

  const emit = defineEmits();
  const {product, closeModal, category} = defineProps<{ category: Category, product?: Product, closeModal: Function}>();
  const formErrors = ref();
  const form = ref({...product});
  const schema = zod.object({ name: zod.string(), price: zod.coerce.number().min(1)});

  const {mutate, loading, errors} = useMutation(
    () => axios({
      url: form.value.id ? `/api/products/${form.value.id}`: `/api/products`, 
      data: {...form.value, categoryId: category.id},
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
    <div class="text-h5 mb-4">{{ product?.id ? 'Edit' : 'Add New' }} Product</div>
    <v-alert class="mb-4" v-if="errors?.categoryId" color="error">{{ errors?.categoryId[0] }}</v-alert>
    <v-text-field label="Name"  :error="!!formErrors?.name" :error-messages="formErrors?.name?._errors" v-model="form.name" />
    <v-text-field label="Price"  :error="!!formErrors?.price" :error-messages="formErrors?.price?._errors" v-model="form.price" type="number" />
    <div class="d-flex ga-2 mt-6">
      <v-btn type="submit" class="bg-primary" :loading="loading">submit</v-btn>
      <v-btn type="button" @click="handleModalClose">cancel</v-btn>
    </div>
  </v-form>
</template>