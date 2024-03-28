import { ref } from 'vue';

export default function useModal() {

  const modal = ref<boolean>(false);
  const openModal = () => modal.value = true;
  const closeModal = () => modal.value = false;

  return { modal, openModal, closeModal };
}