import Vue from 'vue';
import Vuex from 'vuex';

import borrow from '@/helper/services/borrow.service';
// import auth from '@/store/modules/auth'

import utils from '@/helper/utils/utils';

Vue.use(Vuex);

export default {
  namespaced: true,
  state: {
    borrows: [],
    reportData: [],
  },
  mutations: {
    SET_REPORT_DATA(state, array) {
      state.reportData = array;
    },
    SET_BORROWS(state, list) {
      state.borrows = list;
    },
  },
  actions: {
    async fetchBorrows({ commit }) {
      try {
        const { data } = await borrow.fetchBorrows();
        const array = await utils.filterData( this.state.auth.userCredential.data.office_id , data)
        commit('SET_BORROWS', array);
      } catch (error) {
        throw error;
      }
    },
    async postBorrows({ commit }, data) {
      const payload = {
        request_by_id: this.state.auth.userCredential.data.user_id,
        office_id: this.state.auth.userCredential.data.office_id,
        ...data,
      }
      try {
        await borrow.postBorrows(payload);
      } catch (e) {
        throw e;
      }
    },
    async approveBorrow({ coomit }, [payload, id]) {
      try {
        await borrow.approveBorrow([payload, id]);
      } catch (e) {
        throw e;
      }
    },
    async rejectBorrow({ coomit }, [payload, id]) {
      try {
        await borrow.rejectBorrow([payload, id]);
      } catch (e) {
        throw e;
      }
    },
    async returnBorrow({ coomit }, id) {
      try {
        await borrow.returnBorrow(id);
      } catch (e) {
        throw e;
      }
    },

    async borrowReportData({ commit }, payload) 
    {
      try {
        const { data } = await borrow.borrowReport(payload)
        commit('SET_REPORT_DATA', data)
      } catch(e) {
        throw e;
      }
    },
    printForm({ commit }, payload) {
      try {
        borrow.printForm(payload);
      } catch(e) {
        throw e;
      }
    },

  },
};
