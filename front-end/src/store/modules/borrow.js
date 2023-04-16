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
    statisticsBorrow: [],
  },
  mutations: {
    SET_CONSENT_BORROWS(state, array) {
      state.borrows = array;
    },
    SET_REPORT_DATA(state, array) {
      state.reportData = array;
    },
    SET_BORROWS(state, list) {
      state.borrows = list;
    },
    SET_BORROW_STATISTICS(state, list) {
      state.statisticsBorrow = list;
    },
  },
  actions: {
    async fetchBorrows({ commit }) {
      try {
        const { data } = await borrow.fetchBorrows();
        const array = await utils.filterData(this.state.auth.userCredential.data.office_id, data);
        commit('SET_BORROWS', array);
      } catch (error) {
        throw error;
      }
    },
    async fetchAllBorrows({ commit }) {
      try {
        const { data } = await borrow.fetchBorrows();
        // const array = await utils.filterData(this.state.auth.userCredential.data.office_id, data);
        commit('SET_BORROWS', data);
      } catch (error) {
        throw error;
      }
    },
    async fetchConsentBorrows({ commit }) {
      try {
        const { data } = await borrow.fetchBorrows();
        const array = await utils.filterConsentBorrowa(data);
        commit('SET_CONSENT_BORROWS', array);
      } catch (error) {
        throw error;
      }
    },
    async postBorrows({ commit }, data) {
      const payload = {
        request_by_id: this.state.auth.userCredential.data.user_id,
        office_id: this.state.auth.userCredential.data.office_id,
        ...data,
      };
      try {
        await borrow.postBorrows(payload);
      } catch (e) {
        throw e;
      }
    },
    async approveBorrow({ commit }, [payload, id]) {
      try {
        await borrow.approveBorrow([payload, id]);
      } catch (e) {
        throw e;
      }
    },
    async forwardBorrow({ commit }, [payload, id]) {
      try {
        await borrow.forwardBorrow([payload, id]);
      } catch (e) {
        throw e;
      }
    },
    async rejectBorrow({ commit }, [payload, id]) {
      try {
        await borrow.rejectBorrow([payload, id]);
      } catch (e) {
        throw e;
      }
    },
    async returnBorrow({ commit }, id) {
      try {
        await borrow.returnBorrow(id);
      } catch (e) {
        throw e;
      }
    },

    async borrowReportData({ commit }, payload) {
      try {
        const { data } = await borrow.borrowReport(payload);
        commit('SET_REPORT_DATA', data);
      } catch (e) {
        throw e;
      }
    },
    printForm({ commit }, payload) {
      try {
        borrow.printForm(payload);
      } catch (e) {
        throw e;
      }
    },
    async getBorrowStatistics({ commit }) {
      const { data } = await borrow.getBorrowStatistics();
      commit('SET_BORROW_STATISTICS', data);
    },

    borrowReportListPdf({ commit }, payload) {
      borrow.borrowReportListPdf(payload);
    }
  },
};
