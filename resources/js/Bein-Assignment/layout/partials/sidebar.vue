<script setup lang="ts">
  import {ref} from 'vue';
  import sidebarItems from './sidebar-items';
  const open = ref([]);
</script>

<template>
  <v-navigation-drawer expand-on-hover rail>
    <v-card width="300" style="min-height: 100svh;border-radius:0px !important;" class="bg-primary">
      <v-list v-model:opened="open">
        <template v-for="(item) in sidebarItems" :key="item.title"> 
          <v-list-group v-if="item.children">
            <template v-slot:activator="{ props }">
              <v-list-item v-bind="props" :value="item.title" :title="item.title" :prepend-icon="item.icon" />
            </template>
            <v-list class="border-s ml-7 py-0 my-0" value="">
              <router-link class="text-white" v-for="child in item.children" style="text-decoration: none;" :to="`/${child.path}`" :key="child.title">
                <v-list-item class="ml-8" :value="child.title" :title="child.title" :prepend-icon="child.icon"/>
              </router-link>
            </v-list>
          </v-list-group>

          <router-link class="text-white" v-else style="text-decoration: none;" :to="`/${item.path}`">
            <v-list-item  :value="item.title" :title="item.title" :prepend-icon="item.icon" />
          </router-link>  

        </template>
      </v-list>
    </v-card>
  </v-navigation-drawer>
</template>