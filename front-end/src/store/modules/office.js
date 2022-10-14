import Vue from 'vue';
import Vuex from 'vuex';

import office from '@/helper/services/office.service';

Vue.use(Vuex);

export default {
  namespaced: true,
  state: {
    offices: [],
    officeEquipments: [], // offices and their equipments
  },
  mutations: {
    SET_OFFICE_EQUIPMENTS(state, list) {
      state.officeEquipments = list;
    },
    SET_OFFICE(state, data) {
      state.offices = data;
    },
  },
  actions: {
    async fetchOffice({ commit }) {
      try {
        const { data } = await office.fetchOffice();
        commit('SET_OFFICE', data);
      } catch (error) {
        throw error;
      }
    },
    async createOffice({ commit }, payload) {
      // console.log(payload);
      try {
        await office.createOffice(payload);
      } catch (e) {
        throw e;
      }
    },
    async fetchOfficeEquipments({ commit }) {
      try {
        const { data } = await office.fetchOfficeEquipments();
        commit('SET_OFFICE_EQUIPMENTS', data);
      } catch (e) {
        throw e;
      }
    },
  },
};
