import Vue from 'vue';
import Vuex from 'vuex';

import inventory from '@/helper/services/inventory.service';

Vue.use(Vuex);

export default {
  namespaced: true,
  state: {
    inventories: [],
  },
  mutations: {
    SET_INVENTORIES(state, list) {
      state.inventories = list;
    },
  },
  actions: {
    async fetchInventory({ commit }) {
      try {
        const { data } = await inventory.fetchInventory();
        commit('SET_INVENTORIES', data);
      } catch (error) {
        throw error;
      }
    },
    async createInventory({ commit }, payload) {
      try {
        await inventory.createInventory(payload);
      } catch (error) {
        throw error;
      }
    },
  },
};
