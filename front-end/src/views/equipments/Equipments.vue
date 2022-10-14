<template>
  <v-card>
    <v-tabs v-model="tab" centered icons-and-text>
      <v-tabs-slider></v-tabs-slider>

      <v-tab href="#office-equipment-tab">
        Office Equipments
      </v-tab>

      <v-tab href="#equipment-tab">
        Equipments
      </v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item value="office-equipment-tab">
        <v-card flat>
          <equipments-office-tab></equipments-office-tab>
        </v-card>
      </v-tab-item>
      <v-tab-item value="equipment-tab">
        <v-card flat>
          <equipments-tab></equipments-tab>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</template>

<script>
import EquipmentsOfficeTab from './EquipmentsOfficeTab.vue';
import EquipmentsTab from './EquipmentsTab.vue';

export default {
  components: { EquipmentsTab, EquipmentsOfficeTab },
  name: 'Equipment',
  data() {
    return {
      tab: null,
    };
  },
};
</script>
