<script setup lang="ts">
import axios from 'axios';
import useAuth from '../../stores/auth';

const auth = useAuth();

async function logout(){
  await axios.post('api/logout');
  await auth.refresh();
}
</script>
<template>
    <div class="text-center">
      <v-menu >
        <template v-slot:activator="{ props }">
          <button class="d-flex align-center ga-2"  v-bind="props">
            <v-avatar color="transparent">
              <!-- <Icon icon="userCircle" size="x-large"/> -->
              <v-img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John" />
              </v-avatar>
              <div class="d-flex flex-column">
                <p class="text-capitalize font-weight-bold">
                  {{ auth.user?.username }}
                </p>
                <p class="text-capitalize text-caption text-start text-grey-lighten-1">
                  admin
                </p>
              </div>
            </button>
        </template>

        <v-card class="mx-auto pa-2" width="200">
          <v-list>
            <v-list-subheader>PROFILE</v-list-subheader>

            <v-list-item @click="logout" rounded="xl">
              <template v-slot:prepend>
                <v-icon icon="mdi-logout" />
              </template>
              <v-list-item-title v-text="'logout'" />
            </v-list-item>
          
          </v-list>
        </v-card>
      </v-menu>
    </div>
</template>