import Vue from 'vue';
import Vuex from 'vuex';

import user from '@/helper/services/user.service';
import { async } from 'q';

Vue.use(Vuex);

export default {
  namespaced: true,
  state: {
    users: [],
    userEquipment: [],
  },
  mutations: {
    SET_USERS(state, data) {
      state.users = data;
    },
    SET_USER_EQUIPMENTS(state, data) {
      state.userEquipment = data
    }
  },
  actions: {
    async fetchUsers({ commit }) {
      try {
        const { data } = await user.users();
        commit('SET_USERS', data);
      } catch (error) {
        throw error;
      }
    },
    async createUsers({ commit }, payload) {
      try {
        await user.createUsers(payload);
      } catch (e) {
        throw e;
      }
    },
    async updateUser({ commit }, [id, payload]) {
      try{
        await user.updateUser(id, payload)
      } catch(e) {
        throw e;
      }
    },
    async fetchUserEquipments({ commit }, userId) {
      try{
        const { data } = await user.fetchUserEquipments(userId)
        commit('SET_USER_EQUIPMENTS', data);
      } catch(e) {
        throw e;
      }
    }
  },
};
