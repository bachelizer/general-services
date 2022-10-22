<template>
  <v-card>
    <v-card-title class="align-start">
      <span class="font-weight-semibold">Services Statistics Card</span>
    </v-card-title>

    <!-- <v-card-subtitle class="mb-8 mt-n5">
        <span class="font-weight-semibold text--primary me-1">Total 48.5% Growth</span>
        <span>😎 this month</span>
      </v-card-subtitle> -->

    <v-card-text>
      <v-row>
        <v-col
          v-for="data in servicesStatistics"
          :key="data.request_status"
          class="d-flex align-center"
        >
          <v-avatar
            size="44"
            :color="resolveStatisticsIconVariation(data.request_status).color"
            rounded
            class="elevation-1"
          >
            <v-icon dark color="white" size="30">
              {{ resolveStatisticsIconVariation(data.request_status).icon }}
            </v-icon>
          </v-avatar>
          <div class="ms-3">
            <p class="text-xs mb-0">
              {{ data.request_status }}
            </p>
            <h3 class="text-xl font-weight-semibold">
              {{ data.total }}
            </h3>
          </div>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import {
  mdiAccountClockOutline,
  mdiCheckDecagramOutline 
} from '@mdi/js';
import { mapActions, mapState } from 'vuex';

export default {
  setup() {
    const statisticsData = [
      {
        title: 'Pending',
        total: '5',
      },
      {
        title: 'Served',
        total: '10',
      },
      {
        title: 'Fulfilled',
        total: '1',
      },
    ];

    const resolveStatisticsIconVariation = data => {
      if (data === 'Pending') return { icon: mdiAccountClockOutline, color: 'warning' };
      if (data === 'Served') return { icon: mdiCheckDecagramOutline, color: 'success' };
      if (data === 'Fulfilled') return { icon: mdiCheckDecagramOutline, color: 'primary' };

      return { icon: mdiTagCheckOutline , color: 'success' };
    };

    return {
      statisticsData,
      resolveStatisticsIconVariation,

      // icons
      icons: {
        mdiAccountClockOutline,
        mdiCheckDecagramOutline,
      },
    };
  },
  created() {
    this.onload();
  },
  methods: {
    ...mapActions('service', ['getServicesStatistics']),
    onload() {
      this.getServicesStatistics();
    },
  },
  computed: {
    ...mapState('service', ['servicesStatistics']),
  },
};
</script>
