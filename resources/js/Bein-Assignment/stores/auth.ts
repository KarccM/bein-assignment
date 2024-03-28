import { defineStore } from 'pinia'
import axios from 'axios';

const useAuth = defineStore('auth', {
  state: () => ({
    user: {
      permissions: [],
    },
    loggedIn: false,
  }),
  actions: {
    async refresh() {
      try {
        const { data, status } = await axios.get('/api/profile');
        if (status === 200) {
          this.user = data.data;
          this.loggedIn = true;
        }
      } catch (err) {
        this.user = {};
        this.loggedIn = false;
      }
    },

    setLoggedIn(loggedIn: boolean) {
      this.loggedIn = loggedIn;
    },

    can(permission: string) {
      return this.user.permissions.some((_: string) => _ === permission);
    },
  },
})

export default useAuth;