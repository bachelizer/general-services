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
                placeholder="Search office equipment"
                hide-details
              ></v-text-field>
            </v-col>
            <v-spacer></v-spacer>
            <!-- <v-btn elevation="2" small class="mr-10 mt-2" fab color="primary">
              <v-icon @click="equipmentFormDialog = true">
                {{ icons.mdiPlus }}
              </v-icon>
            </v-btn> -->
          </v-row>
        </v-col>
        <v-data-table :headers="headers" :items="officeEquipments" :search="search">
          <template v-slot:item.index="{ item, index }">
            {{ index + 1 }}
          </template>
          <template v-slot:item.actions="{ item }">
            <v-btn small @click="view(item)" color="success"> View </v-btn>
          </template>
        </v-data-table>
      </v-card>
      <equipments-office-full-dialog
        :officeId = "officeId"
        :equipments="equipments"
        :dialog="fullDialog"
        @close="fullDialog = false"
      ></equipments-office-full-dialog>
    </v-col>
  </v-row>
</template>
<script>
import { mdiPlus } from '@mdi/js';
import { mapActions, mapState } from 'vuex';
import EquipmentsOfficeFullDialog from './EquipmentsOfficeFullDialog.vue';

export default {
  components: { EquipmentsOfficeFullDialog },
  name: 'EquipmentsOfficeTab',
  data() {
    return {
      officeId: 0,
      equipments: [],
      fullDialog: false,
      search: '',
      icons: {
        mdiPlus,
      },
      headers: [
        {
          text: '',
          value: 'index',
          width: '5%',
        },
        {
          text: 'Office',
          value: 'office',
        },
        {
          text: 'Action',
          value: 'actions',
        },
      ],
    };
  },
  created() {
    this.onLoad();
  },
  methods: {
    ...mapActions('office', ['fetchOfficeEquipments']),
    onLoad() {
      this.fetchOfficeEquipments();
    },
    view(item) {
      this.fullDialog = true;
      this.equipments = item.equipments;
      this.officeId = item.id;
    // console.log(item)
    },
  },
  computed: {
    ...mapState('office', ['officeEquipments']),
  },
};
</script>
