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
            <v-btn elevation="2" small class="mr-10 mt-3" color="info" href="/files/po_template.xlsx" download>
              Download PO template
            </v-btn>
            <v-btn elevation="2" small class="mr-10 mt-3" color="info" href="/files/pr_template.xlsx" download>
              Download PR template
            </v-btn>
            <v-btn elevation="2" small class="mr-10 mt-2" fab color="primary">
              <v-icon @click="(dialog = true), (action = 'create')">
                {{ icons.mdiPlus }}
              </v-icon>
            </v-btn>
          </v-row>
        </v-col>
        <v-data-table :headers="headers" :items="inventories" :search="search">
          <template v-slot:item.available_stock="{ item }">
            {{ item.available_stock }}
            <v-badge
              v-if="item.available_stock < 3"
              dot
              :color="getStatusColor(item.available_stock)"
            ></v-badge>
          </template>
          <!-- <template v-slot:item.borrower="{ item }">
             {{ item.borrower.first_name }} {{ item.borrower.last_name }}
            </template>
            <template v-slot:item.purpose="{ item }">
             {{ spliceString(item.purpose) }}
            </template> -->
          <template v-slot:item.actions="{ item }">
            <v-btn @click="(replenishDialog = true), (replenishData = item)" small color="success">
              Replenish
            </v-btn>
            <v-btn
              class="ml-2"
              @click="(despenseFormDialog = true), (stockId = item.id), (useUnit = item.unit)"
              small
              color="success"
            >
              Use
            </v-btn>
          </template>
        </v-data-table>
      </v-card>
    </v-col>
    <inventory-form :dialog="dialog" @close="closeForm" @submit="handleFormSubmit"></inventory-form>
    <inventory-replenish-form
      :payload="replenishData"
      :dialog="replenishDialog"
      @close="closeReplenishForm"
      @submit="handleReplenishSubmit"
    ></inventory-replenish-form>
    <inventory-despense-form
      :payload="{ unit: useUnit }"
      :id="stockId"
      :dialog="despenseFormDialog"
      @close="despenseFormDialog = false"
      @submit="handleDespenseSubmit"
    >
    </inventory-despense-form>
  </v-row>
</template>
<script>
import { mdiPlus } from '@mdi/js';

import { mapActions, mapState } from 'vuex';

import PageTitle from '@/components/PageTitle.vue';
import InventoryForm from './InventoryForm.vue';
import InventoryReplenishForm from './InventoryReplenishForm.vue';
import InventoryDespenseForm from './InventoryDespenseForm.vue';

export default {
  components: { PageTitle, InventoryForm, InventoryReplenishForm, InventoryDespenseForm },
  name: 'Inventory',
  data() {
    return {
      useUnit: 0,
      despenseFormDialog: false,
      stockId: 0,
      replenishData: {},
      replenishDialog: false,
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
    ...mapActions('inventory', ['createInventory', 'replenishInventory', 'despenseInventory']),
    closeForm() {
      this.dialog = false;
    },
    closeReplenishForm() {
      this.replenishDialog = false;
    },
    async handleFormSubmit(payload) {
      await this.createInventory(payload);
      this.$store.dispatch('inventory/fetchInventory');
      this.closeForm();
    },
    async handleReplenishSubmit(payload) {
      await this.replenishInventory([payload, payload.id]);
      this.closeReplenishForm();
      this.$store.dispatch('inventory/fetchInventory');
    },
    getStatusColor(count) {
      if (count < 3) return 'warning';
      return '';
    },
    async handleDespenseSubmit(payload, id) {
      await this.despenseInventory([payload, id]);
      this.despenseFormDialog = false;
      this.$store.dispatch('inventory/fetchInventory');
    },
  },
  computed: {
    ...mapState('inventory', ['inventories']),
  },
};
</script>
