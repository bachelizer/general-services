import Vue from 'vue';
import Vuex from 'vuex';

import router from '../../router';
import auth from '@/helper/services/auth.service';

Vue.use(Vuex);

export default {
  namespaced: true,
  state: {
    userCredential: {},
  },
  mutations: {
    SET_USER_CREDENTIAL(state, obj) {
      state.userCredential = obj;
    },
  },
  actions: {
    async login({ commit }, payload) {
      try {
        const { data } = await auth.login(payload);
        // console.log(payload)
        commit('SET_USER_CREDENTIAL', data);
        if (data.data.role_id !== 3) {
          window.location.assign('/dashboard');
        } else {
          window.location.assign('/service');
        }
      } catch (error) {
        throw error;
      }
    },
    async logOut({ commit }) {
      try {
        commit('SET_USER_CREDENTIAL', null);
        sessionStorage.clear();
        router.push('/');
      } catch (error) {
        console.log(error);
      }
    },
  },
};
