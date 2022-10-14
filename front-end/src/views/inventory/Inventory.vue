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
        <!-- <v-data-table :headers="headers" :items="borrows" :search="search">
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
          </v-data-table> -->
      </v-card>
    </v-col>
  </v-row>
</template>
<script>

import { mdiPlus } from '@mdi/js';
import PageTitle from '@/components/PageTitle.vue';

export default {
  components: { PageTitle },
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
  created() {},
  methods: {},
  computed: {},
};
</script>
