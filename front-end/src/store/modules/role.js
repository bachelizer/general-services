import Vue from 'vue';
import Vuex from 'vuex';

import role from '@/helper/services/role.service';

Vue.use(Vuex);

export default {
  namespaced: true,
  state: {
    roles: [],
  },
  mutations: {
    SET_ROLES(state, data) {
      state.roles = data;
    },
  },
  actions: {
    async fetchRole({ commit }) {
      try {
        const { data } = await role.fetchRole();
        commit('SET_ROLES', data);
      } catch (error) {
        throw error;
      }
    },
  },
};
