import Vue from 'vue';
import Vuex from 'vuex';

import outsource from '@/helper/services/outsource.service';

Vue.use(Vuex);

export default {
  namespaced: true,
  state: {
    outSources: [],
  },
  mutations: {
    SET_OUT_SOURCES(state, data) {
      state.outSources = data;
    },
  },
  actions: {
    async fetchOutSources({ commit }) {
      const { data } = await outsource.fetchOutsources();
      commit('SET_OUT_SOURCES', data);
    },
    async createOutsource({ commit }, payload) {
      await outsource.createOutsource(payload);
    },
  },
};
