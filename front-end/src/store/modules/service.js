import Vue from 'vue';
import Vuex from 'vuex';

import service from '@/helper/services/service.service';

import utils from '@/helper/utils/utils';

Vue.use(Vuex);

export default {
  namespaced: true,
  state: {
    maintenances: [],
    services: [],
    reportData: [],
    servicesStatistics: [],
  },
  mutations: {
    SET_REPORT_DATA(state, array) {
      state.reportData = array;
    },
    SET_MAINTENANCES(state, list) {
      const refinedObj = list.map(x => {
        x.request_by.full_name = `${x.request_by.last_name}, ${
          x.request_by.first_name
        } ${x.request_by.last_name.substring(0, 1)}`;
        x.served_by
          ? (x.served_by.full_name = `${x.served_by.last_name}, ${
              x.served_by.first_name
            } ${x.served_by.last_name.substring(0, 1)}`)
          : null;
        return x;
      });
      state.maintenances = refinedObj;
    },
    SET_SERVICES(state, list) {
      state.services = list;
    },
    SET_SERVICES_STATISTICS(state, list) {
      state.servicesStatistics = list;
    },
  },
  actions: {
    // service request
    async fetchMaintenance({ commit }) {
      // eslint-disable-next-line no-useless-catch
      try {
        const { data } = await service.fetchMaintenance();
        const array = await utils.filterDataServices(this.state.auth.userCredential.data.office_id, data);
        commit('SET_MAINTENANCES', array);
      } catch (error) {
        throw error;
      }
    },
    // services types
    async fetchServices({ commit }) {
      try {
        const { data } = await service.fetchServices();
        commit('SET_SERVICES', data);
      } catch (error) {
        throw error;
      }
    },
    async postMaintenance({ commit }, data) {
      const payload = {
        request_by_id: this.state.auth.userCredential.data.user_id,
        ...data,
      };
      try {
        await service.postMaintenance(payload);
      } catch (error) {
        throw error;
      }
    },
    async servedMaintenance({ commit }, [data, id]) {
      try {
        await service.servedMaintenance(data, id);
      } catch (e) {
        throw e;
      }
    },
    async evaluateMaintenance({ commit }, [data, id]) {
      try {
        await service.evaluateMaintenance(data, id);
      } catch (e) {
        throw e;
      }
    },
    async serviceReportData({ commit }, payload) {
      try {
        const { data } = await service.serviceReport(payload);
        commit('SET_REPORT_DATA', data);
      } catch (e) {
        throw e;
      }
    },
    servicePDF({ commit }, id) {
      try {
        service.servicePDF(id);
      } catch (e) {
        throw e;
      }
    },
    async getServicesStatistics({ commit }) {
      const { data } = await service.getServicesStatistics();
      commit('SET_SERVICES_STATISTICS', data);
    },
    serviceReportListPdf({ commit }, payload) {
      service.serviceReportListPdf(payload)
    }
  },
};
