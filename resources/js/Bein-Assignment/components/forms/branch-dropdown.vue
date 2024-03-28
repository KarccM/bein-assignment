<script setup lang="ts">
  import { onMounted } from 'vue';
  import useAuth from '../../stores/auth';
  import AsyncDropdown from './async-dropdown.vue'
  import useSnack from '../../stores/snackbar';
  const snackbar = useSnack();

  const props = defineProps({
    url: {type:String, default:'branches'},
    label: {type:String, default:'Branch'},
    returnObject: { type: Boolean, default: false},
    title: { type: String, default: 'name'},
    value: { type: String, default: 'id'},
    variant: {type: String, default: 'filled'},
    error: Boolean,
    errorMessages: Array,
  });

  const emit = defineEmits();

  const auth = useAuth();
  onMounted(() => {
    if(auth.user.branches.length === 0) {
      snackbar.showErrorSnackbar({message:'please enter branch for current user'});
    }

    if(auth.user.branches.length === 1) {
      if(props.returnObject) emit('update:model-value', auth.user.branches[0])
      else emit('update:model-value', auth.user.branches?.[0].id)
    }
  })

</script>

<template>
  <async-dropdown 
    v-show="auth.user.branches.length > 1"
    @update:model-value="e => emit('update:model-value', e)"
    :label="label"
    :url="url"
    :return-object="returnObject"
    :title="title"
    :value="value"
    :variant="variant"
    :items="auth.user.branches"
    :error="error"
    :error-messages="errorMessages"
  />
</template>