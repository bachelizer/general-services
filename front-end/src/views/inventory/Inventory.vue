<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <PageTitle :title="'Inventory'" :subTitle="'Panel for inventory.'" />
        <v-col>
          <v-row>
            <v-col cols="8" md="5">
              <v-text-field
                v-model="search"
                outlined
                dense
                placeholder="Search from inventory"
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
        <v-data-table :headers="headers" :items="inventories" :search="search">
          <!-- <template v-slot:item.approval_status="{ item }">
              <v-chip small class="ma-2" :color="getStatusColor(item.approval_status)">
                {{ item.approval_status }}
              </v-chip>
            </template> -->
          <!-- <template v-slot:item.borrower="{ item }">
             {{ item.borrower.first_name }} {{ item.borrower.last_name }}
            </template>
            <template v-slot:item.purpose="{ item }">
             {{ spliceString(item.purpose) }}
            </template> -->
          <template v-slot:item.actions="{ item }">
            <v-btn small color="success"> Replenish </v-btn>
          </template>
        </v-data-table>
      </v-card>
    </v-col>
    <inventory-form :dialog="dialog" @close="closeForm" @submit="handleFormSubmit"></inventory-form>
  </v-row>
</template>
<script>
import { mdiPlus } from '@mdi/js';

import { mapActions, mapState } from 'vuex';

import PageTitle from '@/components/PageTitle.vue';
import InventoryForm from './InventoryForm.vue';

export default {
  components: { PageTitle, InventoryForm },
  name: 'Inventory',
  data() {
    return {
      dialog: false,
      status: '',
      action: '',
      icons: {
        mdiPlus,
      },
      search: '',
      headers: [
        {
          text: 'Name',
          value: 'inventory_name',
          sortable: true,
        },
        { text: 'Long name', value: 'name' },
        { text: 'Available stock', value: 'available_stock' },
        { text: 'Unit', value: 'unit' },
        {
          align: 'center',
          text: 'Actions',
          value: 'actions',
        },
      ],
    };
  },
  created() {
    this.$store.dispatch('inventory/fetchInventory');
  },
  methods: {
    ...mapActions('inventory', ['createInventory']),
    closeForm() {
      this.dialog = false;
    },
    async handleFormSubmit(payload) {
      await this.createInventory(payload);
      this.closeForm();
    },
  },
  computed: {
    ...mapState('inventory', ['inventories']),
  },
};
</script>
