<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <PageTitle :title="'Borrow'" :subTitle="'Panel for borrows.'" />
        <v-col>
          <v-row>
            <v-col cols="8" md="5">
              <v-text-field
                v-model="search"
                outlined
                dense
                placeholder="Search borrowed"
                hide-details
              ></v-text-field>
            </v-col>
            <v-spacer></v-spacer>
            <v-btn elevation="2" small class="mr-10 mt-2" fab color="primary">
              <v-icon @click="(dialog = true), (borrow = {}), (action = 'create')">
                <!-- <v-icon> -->
                {{ icons.mdiPlus }}
              </v-icon>
            </v-btn>
          </v-row>
        </v-col>
        <v-data-table :headers="headers" :items="borrows" :search="search">
          <template v-slot:item.approval_status="{ item }">
            <v-chip small class="ma-2" :color="getStatusColor(item.approval_status)">
              {{ item.approval_status }}
            </v-chip>
          </template>
          <template v-slot:item.borrower="{ item }">
            {{ item.borrower.first_name }} {{ item.borrower.last_name }}
          </template>
          <template v-slot:item.purpose="{ item }">
            {{ spliceString(item.purpose) }}
          </template>
          <template v-slot:item.actions="{ item }">
            <v-btn small @click="view(item)" color="success"> View </v-btn>
          </template>
        </v-data-table>
      </v-card>
      <borrow-form
        @close="(dialog = false), (borrow = {}), (action = '')"
        @reload="onload"
        :data="borrow"
        :action="action"
        :dialog="dialog"
        :status="status"
      ></borrow-form>
    </v-col>
  </v-row>
</template>
<script>
import { mapState, mapActions } from 'vuex';

import { mdiPlus } from '@mdi/js';
import PageTitle from '@/components/PageTitle.vue';
import BorrowForm from './BorrowForm.vue';

import utils from '../../helper/utils/utils';

export default {
  components: { PageTitle, BorrowForm },
  name: 'Borrow',
  data() {
    return {
      dialog: false,
      status: '',
      action: '',
      borrow: {},
      icons: {
        mdiPlus,
      },
      search: '',
      headers: [
        {
          text: 'Status',
          value: 'approval_status',
          sortable: true,
        },
        { text: 'Office of', value: 'office.office' },
        { text: 'Borrower', value: 'borrower' },
        { text: 'Equipment', value: 'equipment.code' },
        {
          text: 'Qty.',
          value: 'qty',
        },
        {
          text: 'Purpose',
          value: 'purpose',
        },
        {
          align: 'center',
          text: 'Actions',
          value: 'actions',
        },
      ],
    };
  },
  created() {
    this.onload();
  },
  methods: {
    ...mapActions('borrow', ['fetchBorrows']),
    onload() {
      this.fetchBorrows();
    },
    view(data) {
      this.borrow = data;
      this.dialog = true;
    },
    getStatusColor(status) {
      if (status === 'Pending') return 'warning';
      if (status === 'Approved') return 'success';
      if (status === 'Rejected') return 'error';
      if (status === 'Returned') return 'primary';
      return 'info';
    },
    spliceString(text) {
      return utils.spliceLongString(text, 30);
    },
  },
  computed: {
    ...mapState('borrow', ['borrows']),
  },
};
</script>
