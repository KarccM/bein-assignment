import { ref, onMounted } from 'vue';


const useQuery = (fetchCallback: Function, options = { enabled: true }) => {

  const errors = ref();
  const loading = ref<boolean>(false);
  const data = ref();

  const refetch = async () => {
    loading.value = true;
    try {
      const { data: fetchedData } = await fetchCallback();
      data.value = fetchedData.data;
      loading.value = false;
    } catch (backendErros) {
      if (backendErros.response.status === 422)
        errors.value = backendErros.response.data.errors;
      loading.value = false;
    }
  }

  onMounted(async () => {
    if (options.enabled) {
      loading.value = true;
      try {
        const { data: fetchedData } = await fetchCallback();
        data.value = fetchedData.data;
        loading.value = false;
      } catch (backendErros) {
        if (backendErros?.response?.status === 422)
          errors.value = backendErros.response.data.errors;
        loading.value = false;
      }
    }
  });

  return {
    errors,
    loading,
    refetch,
    data,
  }
}

export default useQuery;