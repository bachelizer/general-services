<template>
  <v-card>
    <v-card-title class="align-start">
      <span class="font-weight-semibold">Borrow Statistics Card</span>
    </v-card-title>

    <!-- <v-card-subtitle class="mb-8 mt-n5">
      <span class="font-weight-semibold text--primary me-1">Total 48.5% Growth</span>
      <span>😎 this month</span>
    </v-card-subtitle> -->

    <v-card-text>
      <v-row>
        <v-col
          v-for="data in statisticsBorrow"
          :key="data.title"
          class="d-flex align-center"
        >
          <v-avatar
            size="44"
            :color="resolveStatisticsIconVariation(data.approval_status).color"
            rounded
            class="elevation-1"
          >
            <v-icon dark color="white" size="30">
              {{ resolveStatisticsIconVariation(data.approval_status).icon }}
            </v-icon>
          </v-avatar>
          <div class="ms-3">
            <p class="text-xs mb-0">
              {{ data.approval_status }}
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
  mdiAccountEditOutline,
  mdiCheckDecagramOutline,
  mdiAlertDecagramOutline,
  mdiTagCheckOutline,
  mdiAccountClockOutline,
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
        title: 'Approved',
        total: '3',
      },
      {
        title: 'Rejected',
        total: '10',
      },
      {
        title: 'Returned',
        total: '1',
      },
    ];

    const resolveStatisticsIconVariation = data => {
      if (data === 'Pending') return { icon: mdiAccountClockOutline, color: 'warning' };
      if (data === 'Approved') return { icon: mdiCheckDecagramOutline, color: 'success' };
      if (data === 'Rejected') return { icon: mdiAlertDecagramOutline, color: 'error' };
      if (data === 'Returned') return { icon: mdiCheckDecagramOutline, color: 'primary' };
      if (data === 'Consent') return { icon: mdiAccountEditOutline, color: 'info' };

      return { icon: mdiCheckDecagramOutline, color: 'success' };
    };

    return {
      statisticsData,
      resolveStatisticsIconVariation,

      // icons
      icons: {
        mdiTagCheckOutline,
        mdiAlertDecagramOutline,
        mdiAccountEditOutline,
      },
    };
  },
  created() {
    this.fngetBorrowStatistics();
  },
  methods: {
    ...mapActions('borrow', ['getBorrowStatistics']),
    fngetBorrowStatistics() {
      this.getBorrowStatistics();
    },
  },
  computed: {
    ...mapState('borrow', ['statisticsBorrow']),
  },
};
</script>
