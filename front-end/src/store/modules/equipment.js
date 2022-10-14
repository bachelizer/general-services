import Vue from 'vue';
import Vuex from 'vuex';

import equipment from '@/helper/services/equipment.service';

Vue.use(Vuex);

export default {
  namespaced: true,
  state: {
    equipments: [],
    officeEquipments: [],
  },
  mutations: {
    SET_EQUIPMENT(state, list) {
      state.equipments = list;
    },
    SET_OFFICE_EQUIPMENTS(state, list) {
      state.officeEquipments = list;
    },
  },
  actions: {
    async fetchOfficeEquipment({ commit }) {
      try {
        const { data } = await equipment.fetchOfficeEquipment();
        commit('SET_OFFICE_EQUIPMENTS', data);
      } catch (error) {
        throw error;
      }
    },

    async fetchEquipment({ commit }) {
      try {
        const { data } = await equipment.fetchEquipment();
        commit('SET_EQUIPMENT', data);
      } catch (e) {
        throw e;
      }
    },
    async createEquipment({ commit }, payload) {
      try {
        await equipment.createEquipment(payload);
      } catch (e) {
        throw e;
      }
    },
    async creatOfficeEquipment({ commit }, payload) {
      try {
        await equipment.creatOfficeEquipment(payload);
      } catch (e) {
        throw e;
      }
    },
  },
};
