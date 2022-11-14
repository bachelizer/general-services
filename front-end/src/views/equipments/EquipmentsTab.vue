<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <v-col>
          <v-row>
            <v-col cols="8" md="5">
              <v-text-field
                v-model="search"
                outlined
                dense
                placeholder="Search equipment"
                hide-details
              ></v-text-field>
            </v-col>
            <v-spacer></v-spacer>
            <v-btn elevation="2" small class="mr-10 mt-2" fab color="primary">
              <v-icon @click="equipmentFormDialog = true">
                <!-- <v-icon> -->
                {{ icons.mdiPlus }}
              </v-icon>
            </v-btn>
          </v-row>
        </v-col>
        <v-data-table :headers="headers" :items="equipments" :search="search">
          <template v-slot:item.maintenance_interval="{ item }">
            <span>{{ maintenInterval(item.maintenance_interval) }}</span>
          </template>
        </v-data-table>
      </v-card>
    </v-col>
    <equipment-form
      :dialog="equipmentFormDialog"
      @close="equipmentFormDialog = false"
      @reload="onLoad"
    ></equipment-form>
  </v-row>
</template>
<script>
import { mdiPlus } from '@mdi/js';
import { mapActions, mapState } from 'vuex';
import EquipmentForm from './EquipmentsForm.vue';

export default {
  components: { EquipmentForm },
  name: 'EquipmentsTab',
  data() {
    return {
      equipmentFormDialog: false,
      search: '',
      icons: {
        mdiPlus,
      },
      headers: [
        {
          text: 'Equipment ID',
          value: 'id',
          width: '20%',
        },
        {
          text: 'Equipment',
          value: 'equipment',
        },
        {
          text: 'Regular Maintenance Interval',
          value: 'maintenance_interval',
        },
      ],
    };
  },
  created() {
    this.onLoad();
  },
  methods: {
    ...mapActions('equipment', ['fetchEquipment']),
    onLoad() {
      this.fetchEquipment();
    },
    maintenInterval(days) {
      if (days === 7) return 'Weekly';
      if (days === 31) return 'Monthly';
      if (days === 180) return 'Semiannually';
      if (days === 365) return 'Annully';
      return 'None';
    },
  },
  computed: {
    ...mapState('equipment', ['equipments']),
  },
};
</script>
