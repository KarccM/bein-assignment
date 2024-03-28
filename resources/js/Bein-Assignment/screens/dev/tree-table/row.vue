<script setup lang="ts">
  import { ref } from 'vue';
  import RowChild from './row.vue';
  import Category from '@/types/category'
  
  const {lvl} = defineProps<{category:Category, lvl:number}>()
  const expanded = ref(false);
  const emit = defineEmits()
  const calcIndent= () => 20 * lvl;
</script>

<template>
  <tbody :style="`text-indent: ${calcIndent()}px`">
    <tr>
      <td colspan="2">
        <v-btn density="comfortable" :icon="expanded? 'mdi-menu-down' : 'mdi-menu-right'" type="button" variant="text" @click="expanded=!expanded" :disabled="!category.children?.length && !category.products?.length" />
        <span class="ml-2">{{ category.name }}</span>
      </td>
      <td>
        <div class="d-flex ga-2">
          <v-tooltip text="Add Discount" location="bottom">
            <template v-slot:activator="{ props }">
              <v-btn
                v-bind="props"
                density="comfortable"
                icon="mdi-sale"
                type="button"
                variant="plain"
                color="warning"
                @click="emit('openDiscountModal', category)"
              />
            </template>
          </v-tooltip>
          <v-tooltip text="Add Product" location="bottom">
            <template v-slot:activator="{ props }">
              <v-btn
                v-bind="props"
                density="comfortable"
                icon="mdi-archive-plus"
                type="button"
                variant="plain"
                color="success"
                @click="emit('openProductModal', category)"
              />
            </template>
          </v-tooltip>
          <v-tooltip text="Add Sub Category" location="bottom">
            <template v-slot:activator="{ props }">
              <v-btn 
                v-bind="props"
                density="comfortable"
                icon="mdi-plus"
                type="button"
                variant="plain"
                color="blue"
                @click="emit('openCategoryModal', category)"
              />
            </template>
          </v-tooltip>
          <v-btn 
            density="comfortable"
            icon="mdi-delete"
            type="button"
            variant="plain"
            color="error"
            @click="emit('openDeleteCategoryModal', category)"
          />
        </div>
      </td>
    </tr>
  </tbody>
  <RowChild 
    v-if="expanded && category.children"
    v-for="children in category.children"
    :key="children.id"
    :category="children"
    :lvl="lvl +1"
    @openDiscountModal="(category) => emit('openDiscountModal', category)"
    @openProductModal="(category) => emit('openProductModal', category)"
    @openCategoryModal="(category) => emit('openCategoryModal', category)"
    @openDeleteCategoryModal="(category) => emit('openDeleteCategoryModal', category)"
    @openDeleteProductModal="(product) => emit('openDeleteProductModal', product)"
  />
  <tbody :style="`text-indent: ${calcIndent() * 1.5}px`" v-if="expanded && category.products" v-for="product in category.products" >
    <tr class="text-start">
      <td>
        <v-icon icon="mdi-circle-small" variant="text" />
        <span class="ml-2">{{ product.name }}</span>  
      </td>
      <td>
        <template v-if="product.discount">
          <span class="text-error">
            {{ product.price - product.discount.amount }} After Sale
          </span>
        </template>
        <template v-else>
          {{ product.price }}
        </template>
      </td>
      <td>
        <div class="d-flex ga-2">
          <v-btn
            density="comfortable"
            icon="mdi-delete"
            type="button"
            variant="plain"
            color="error"
            @click="() => emit('openDeleteProductModal', product)"
          />
        </div>
      </td>
    </tr>
  </tbody>
</template>