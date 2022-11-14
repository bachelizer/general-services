<template>
  <v-layout row justify-center>
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
      <v-card>
        <v-toolbar dark color="primary">
          <v-icon @click="$emit('close')">
            {{ icons.mdiClose }}
          </v-icon>
          <!-- <v-toolbar-title>Settings</v-toolbar-title> -->
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn class="mt-3" @click="dialog = false">Close</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-row justify="center" class="mt-10">
          <v-col cols="8">
            <v-card outlined class="pa-5" elevation="1">
              <v-row class="mb-2">
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
                  <v-icon @click="officeFormDialog = true">
                    <!-- <v-icon> -->
                    {{ icons.mdiPlus }}
                  </v-icon>
                </v-btn>
              </v-row>
              <v-data-table :headers="headers" :items="equipments" :search="search">
                <template v-slot:item.maintenance_day="{ item }">
                  <v-chip small class="ma-2" :color="getStatusColor(item.maintenance_day)">
                    {{ getDaysStatus(item.maintenance_day) }}
                  </v-chip>
                </template>
              </v-data-table>
            </v-card>
          </v-col>
        </v-row>
      </v-card>
    </v-dialog>
    <equipment-office-form
      :officeId="officeId"
      :dialog="officeFormDialog"
      :data="formData"
      @close="officeFormDialog = false"
      @reload="this.$emit('reload')"
    ></equipment-office-form>
  </v-layout>
</template>
<script>
import { mdiClose, mdiPlus } from '@mdi/js';
import EquipmentOfficeForm from './EquipmentOfficeForm.vue';

export default {
  components: { EquipmentOfficeForm },
  props: {
    officeId: {
      type: Number,
      default: 0,
    },
    equipments: {
      type: Array,
      default: () => [],
    },
    dialog: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      formData: {},
      officeFormDialog: false,
      search: '',
      icons: {
        mdiClose,
        mdiPlus,
      },
      headers: [
        {
          text: 'Equipment Code',
          value: 'code',
        },
        {
          text: 'Days left for regular maintenance',
          value: 'maintenance_day',
        },
        {
          text: 'Serial Number',
          value: 'serial',
        },
        {
          text: 'Amount',
          value: 'amount',
        },
        {
          text: 'Supplier',
          value: 'supplier',
        },
      ],
    };
  },
  methods: {
    getStatusColor(data) {
      if (data === null) return 'success';
      if (data <= 3 && data !== 0) return 'warning';
      if (data === 0) return 'error';
      return 'success';
    },
    getDaysStatus(data) {
      if (data === null) return 'N/A';
      if (data <= 1) return `${data} day`;
      return `${data} days`;
    },
  },
};
</script>
