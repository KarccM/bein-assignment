<script setup lang="ts">
  import {ref, watch} from 'vue';
  import axios from 'axios';
  import Row from './row.vue'
  import useMutation from '@/hooks/useMutation';
  import useQuery from '@/hooks/useQuery';
  import useModal from '@/hooks/useModal';
  import Product from '@/types/Product';
  import CategoryType from '@/types/Category';
  import DiscountModal from './modals/discount.vue';
  import ProductModal from './modals/product.vue';
  import CategoryModal from './modals/category.vue';
  import DeleteConfirmation from '@/components/deleteConfirmation.vue';
  
  const {mutate:deleteCategory, loading:deletingCategory} = useMutation((category) => axios.delete(`/api/categories/${category.id}`)
  ,{
    onSuccess: () => { 
      refetch();
      closeDeleteModal();
      selectedCategoryForDelete.value = null;
    }
  });
  
  const {mutate:deleteProduct, loading:deletingProductdeleteProduct} = useMutation((product) => axios.delete(`/api/products/${product.id}`)
  ,{
    onSuccess: () => {
      refetch();
      closeDeleteModal();
      selectedProductForDelete.value = null;
    }
  });

  const {data, loading, refetch} = useQuery(() => axios.get('/api/categories'));
  const selectedCategory = ref<CategoryType|null>(null);
  const selectedCategoryForDelete = ref<CategoryType|null>(null);
  const selectedProductForDelete = ref<Product|null>(null);
  
  const {modal:discountModal, openModal: openDiscountModal, closeModal: closeDiscountModal} = useModal();
  const {modal:productModal, openModal: openProductModal, closeModal: closeProductModal} = useModal();
  const {modal:categoryModal, openModal: openCategoryModal, closeModal: closeCategoryModal} = useModal();
  const {modal:deleteModal, openModal:openDeleteModal, closeModal:closeDeleteModal} = useModal();
  
  const handleDelete = () => {
    if(selectedCategoryForDelete.value) deleteCategory(selectedCategoryForDelete.value);
    if(selectedProductForDelete.value) deleteProduct(selectedProductForDelete.value);
  }

  watch(deleteModal, () => {
    if(deleteModal.value === false) {
      selectedCategoryForDelete.value = false;
      selectedProductForDelete.value = false;
    }
  })
</script>
<template>
  <div class="d-flex flex-row-reverse ma-4">
    <v-btn color="blue" prepend-icon="mdi-plus" type="button" @click="() => {
      selectedCategory = null;
      openCategoryModal();
    }">Create Category</v-btn>
  </div>
  <v-table v-if="!loading">
    <Row 
      v-for="category in data"
      :category="category"
      :lvl="1"
      @openProductModal="(category) => {
        selectedCategory = category;
        openProductModal();
      }"
      
      @openCategoryModal="(category) => {
        selectedCategory = category;
        openCategoryModal();
      }"
      
      @openDiscountModal="(category) => {
        selectedCategory = category;
        openDiscountModal();
      }"

      @openDeleteCategoryModal="(category) => {
        selectedCategoryForDelete = category;
        openDeleteModal();
      }"

      @openDeleteProductModal="(product) => {
        selectedProductForDelete = product;
        openDeleteModal();
      }"
    />

    <v-dialog v-model="categoryModal">
      <v-container>
        <v-sheet class="pa-4">
        <CategoryModal :parent="selectedCategory" :close-modal="closeCategoryModal" @refetch="refetch" />
        </v-sheet>
      </v-container>
    </v-dialog>

    <v-dialog v-model="discountModal">
      <v-container>
        <v-sheet class="pa-4">
        <DiscountModal :category="selectedCategory" :close-modal="closeDiscountModal" @refetch="refetch" />
        </v-sheet>
      </v-container>
    </v-dialog>
   
    <v-dialog v-model="productModal">
      <v-container>
        <v-sheet class="pa-4">
          <ProductModal :category="selectedCategory" :close-modal="closeProductModal" @refetch="refetch" />
        </v-sheet>
      </v-container>
    </v-dialog>
  </v-table>

  <delete-confirmation v-model="deleteModal" @deleted="handleDelete" :loading="deletingCategory||deletingProductdeleteProduct" />
</template>