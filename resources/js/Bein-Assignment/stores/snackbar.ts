import { defineStore } from 'pinia'

const useSnack = defineStore('snackbar', {
  state: () => ({
    error: false,
    success: false,
    message: '',
    timeout: 2000,
    location: 'bottom',
  }),
  actions: {
    showErrorSnackbar({ message = '', timeout = 2000, location = 'bottom' }) {
      this.error = true;
      this.message = message;
      this.timeout = timeout;
      this.location = location;
    },
    showSuccessSnackbar({ message = '', timeout = 2000, location = 'bottom' }) {
      this.success = true;
      this.message = message;
      this.timeout = timeout;
      this.location = location;
    },
    closeErrorSnackbar() { this.error = false },
    closeSuccessSnackbar() { this.success = false },
  },
})

export default useSnack;