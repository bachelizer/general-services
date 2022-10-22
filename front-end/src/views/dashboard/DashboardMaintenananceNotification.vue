<template>
  <v-card>
    <v-card-title class="align-start">
      <span>Regular Maintenance Notification</span>
    </v-card-title>
    <v-data-table :items="officeEquipments" :headers="headers">
      <template v-slot:item.maintenance_day="{ item }">
        <v-chip small class="ma-2" :color="getStatusColor(item.maintenance_day)">
          {{ getDaysStatus(item.maintenance_day) }}
        </v-chip>
      </template>
      <template #item.actions="{item}">
        <v-btn small color="primary" @click="applyRegularMaintenance(item)">Apply action</v-btn>
      </template>
    </v-data-table>
    <maintenance-dialog
      :maintenanceData="maintenanceData"
      :dialog="dialog"
      @close="close"
      @submit="maintenanceSubmit"
    ></maintenance-dialog>
  </v-card>
</template>

<script>
import { mapActions, mapState } from 'vuex';

import MaintenanceDialog from './dialogs/MaintenanceDialog.vue';

export default {
  components: { MaintenanceDialog },
  data() {
    return {
      maintenanceData: {},
      dialog: false,
      headers: [
        {
          text: 'Equip Code',
          value: 'code',
        },
        {
          text: 'Days left for regular maintenance',
          value: 'maintenance_day',
        },
        {
          text: 'Office',
          value: 'office.office',
        },
        {
          text: 'Serial Number',
          value: 'serial',
        },
        {
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
    ...mapActions('equipment', [
      'officeEquipmentMaintenanceNotification',
      'officeEquipmentRegularMaintenance',
    ]),
    onLoad() {
      this.officeEquipmentMaintenanceNotification();
    },
    getStatusColor(data) {
      if (data <= 3 && data !== 0) return 'warning';
      return 'error';
    },
    getDaysStatus(data) {
      if (data === 1) return `${data} day`;
      if (data > 1) return `${data} days`;
      return `${data} days, regular maintenance needed`;
    },
    applyRegularMaintenance(data) {
      console.log(data);
      this.maintenanceData = data;
      this.dialog = true;
    },
    close() {
      this.dialog = false;
    },
    async maintenanceSubmit(data) {
      const payload = {
        ...data,
        maintenance_day: data.days_maintenance,
        action_taken: data.action_taken,
        maintained_by: data.maintainedBy,
      };
      try {
        await this.officeEquipmentRegularMaintenance(payload);
        this.onLoad();
        this.close();
      } catch (error) {
        alert(error.message);
      }
    },
  },
  computed: {
    ...mapState('equipment', ['officeEquipments']),
  },
};
</script>
