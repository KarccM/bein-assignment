import { ref } from 'vue';

const useMutation = (
  mutationCallback: Function,
  { onSuccess } = { onSuccess: (result: unknown) => { } }
) => {

  const errors = ref();
  const loading = ref<boolean>(false);

  const mutate = async (data = {}) => {
    loading.value = true;
    try {
      const result = await mutationCallback(data);
      loading.value = false;
      onSuccess?.(result);
    } catch (backendErros) {
      if (backendErros.response?.status === 422)
        errors.value = backendErros.response.data.errors;
      loading.value = false;
    }
  }

  return {
    errors,
    loading,
    mutate,
  }
}

export default useMutation;