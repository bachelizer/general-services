<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <PageTitle :title="'Service'" :subTitle="'Panel for services.'" />
        <v-col>
          <v-row>
            <v-col cols="8" md="5">
              <v-text-field
                id="firstname"
                v-model="search"
                outlined
                dense
                placeholder="Search"
                hide-details
              ></v-text-field>
            </v-col>
            <v-spacer></v-spacer>
            <v-btn elevation="2" small class="mr-10 mt-2" fab color="primary">
              <v-icon @click="(dialog = true), (action = 'create')">
                {{ icons.mdiPlus }}
              </v-icon>
            </v-btn>
          </v-row>
        </v-col>
        <v-data-table :headers="headers" :items="maintenances" :search="search">
          <template v-slot:item.request_status="{ item }">
            <v-chip small class="ma-2" :color="getStatusColor(item.request_status)">
              {{ item.request_status }}
            </v-chip>
          </template>
          <template v-slot:item.reason="{ item }">
            {{ spliceString(item.reason) }}
          </template>
          <template v-slot:item.actions="{ item }">
            <v-btn small color="success" @click="onVeiw(item)"> View </v-btn>
          </template>
        </v-data-table>
      </v-card>
    </v-col>
    <ServiceForm :action="action" :status="status" :dialog="dialog" :data="data" @close="close" @reload="onLoad"/>
  </v-row>
</template>
<script>
import { mdiPlus } from '@mdi/js';
import { mapActions, mapState } from 'vuex';
import PageTitle from '@/components/PageTitle.vue';
import ServiceForm from './ServiceForm.vue';

import utils from '../../helper/utils/utils';

export default {
  components: { PageTitle, ServiceForm },
  name: 'Maintenance',
  data() {
    return {
      action: '',
      status: '',
      data: {},
      dialog: false,
      icons: {
        mdiPlus,
      },
      informationDialog: false,
      search: '',
      headers: [
        {
          text: 'Status',
          value: 'request_status',
          sortable: true,
        },
        { text: 'Office of', value: 'office.office' },
        { text: 'Requested by', value: 'request_by.full_name' },
        { text: 'Details', value: 'reason', filterable: false },
        {
          text: 'Equipment',
          value: 'equipment.equipment',
        },
        {
          text: 'Service',
          value: 'service.service',
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
    this.onLoad();
  },
  methods: {
    ...mapActions('service', ['fetchMaintenance']),
    async onLoad() {
      try {
        await this.fetchMaintenance();
      } catch (e) {
        console.log(e.message);
      }
    },
    onInformation(item) {
      this.informationDialog = true;
      console.log(item);
    },
    getStatusColor(status) {
      if (status === 'Pending') return 'warning';
      if (status === 'Served') return 'success';
      if (status === 'Fulfilled') return 'primary';
      return null;
    },
    onVeiw(item) {
      this.dialog = true;
      this.data = item;
      this.action = 'view';
      if (item.request_status === 'Pending') {
        this.status = 'pending';
      }
      if (item.request_status === 'Served') {
        this.status = 'served';
      }
      if (item.request_status === 'Fulfilled') {
        this.status = 'fulfilled';
      }
    },
    close() {
      this.dialog = false;
      this.data = {};
    },
    spliceString(text) {
      return utils.spliceLongString(text, 30);
    },
  },
  computed: {
    ...mapState('service', ['maintenances']),
  },
};
</script>
