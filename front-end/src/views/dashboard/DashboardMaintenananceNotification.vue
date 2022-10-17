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
        <v-btn small color="primary" @click="applyRegularMaintenance(item.id)">Apply action</v-btn>
      </template>
      </v-data-table
    >
  </v-card>
</template>

<script>
import { mapActions, mapState } from 'vuex';

export default {
  data() {
    return {
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
    ...mapActions('equipment', ['officeEquipmentMaintenanceNotification']),
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
    applyRegularMaintenance(id) {
      alert(id)
    }
  },
  computed: {
    ...mapState('equipment', ['officeEquipments']),
  },
};
</script>
