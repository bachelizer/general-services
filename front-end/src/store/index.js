import Vue from 'vue';
import Vuex from 'vuex';

import createPersistedState from 'vuex-persistedstate';

import office from '@/store/modules/office';
import service from '@/store/modules/service';
import equipment from '@/store/modules/equipment';
import borrow from '@/store/modules/borrow';
import user from '@/store/modules/user';
import role from '@/store/modules/role';
import account from '@/store/modules/account';
import auth from '@/store/modules/auth';
import inventory from '@/store/modules/inventory';
import outsource from '@/store/modules/outsource'

Vue.use(Vuex);

export default new Vuex.Store({
  plugins: [
    createPersistedState({
      storage: window.sessionStorage,
      paths: ['auth.userCredential'],
    }),
  ],
  state: {},
  mutations: {},
  actions: {},
  modules: {
    office,
    service,
    equipment,
    borrow,
    user,
    role,
    account,
    auth,
    inventory,
    outsource,
  },
});
