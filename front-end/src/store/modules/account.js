import Vue from 'vue';
import Vuex from 'vuex';

import account from '@/helper/services/account.service';

Vue.use(Vuex);

export default {
  namespaced: true,
  state: {},
  mutations: {},
  actions: {
    async createAccount({ commit }, payload) {
      await account.createAccount(payload);
    },
  },
};
