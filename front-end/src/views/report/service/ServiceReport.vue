<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <PageTitle :title="'Service Report'" :subTitle="'Panel for service report.'" />
        <v-col cols="12" sm="6">
          <v-row>
            <v-col sm="8">
              <v-menu
                ref="datePckr"
                v-model="datePckr"
                :close-on-content-click="false"
                :return-value.sync="dates"
                transition="scale-transition"
                offset-y
                min-width="290px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    v-model="dateRangeText"
                    label="Date"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                    outlined
                    x-small
                  ></v-text-field>
                </template>
                <v-date-picker v-model="dates" no-title scrollable range>
                  <v-spacer></v-spacer>
                  <v-btn text color="primary" @click="datePckr = false">Cancel</v-btn>
                  <v-btn text color="primary" @click="$refs.datePckr.save(dates)">OK</v-btn>
                </v-date-picker>
              </v-menu>
            </v-col>
            <v-col sm-4>
              <v-btn @click="generate" class="mt-2" color="primary darken-1">
                Generate
              </v-btn>
              <!-- model: {{ dates }} -->
            </v-col>
          </v-row>
        </v-col>
        <v-col>
          <v-row justify="end">
            <v-btn @click="excelExport" class="mt-2" color="primary darken-1" tile>
              Download Data
            </v-btn>
          </v-row>
        </v-col>

        <v-data-table :headers="headers" :items="reportData">
            <template v-slot:item.request_status="{ item }">
              <v-chip small class="ma-2" :color="getStatusColor(item.request_status)">
                {{ item.request_status }}
              </v-chip>
            </template>
            <template v-slot:item.request_by="{ item }">
              {{ item.request_by.first_name }}  {{ item.request_by.last_name }} 
            </template>
          </v-data-table>
      </v-card>
    </v-col>
  </v-row>
</template>
<script>
import xlsx from 'json-as-xlsx';
import { mapActions, mapState } from 'vuex';
import PageTitle from '@/components/PageTitle.vue';

import utils from '@/helper/utils/utils';

export default {
  components: { PageTitle },
  name: 'ServiceReport',
  data() {
    return {
      datePckr: false,
      dates: [],
      headers: [
        {
          text: 'Status',
          value: 'request_status',
          sortable: true,
        },
        { text: 'Office of', value: 'office.office' },
        { text: 'Requested by', value: 'request_by' },
        { text: 'Details', value: 'reason', filterable: false },
        {
          text: 'Equipment',
          value: 'equipment.equipment',
        },
        {
          text: 'Service',
          value: 'service.service',
        },
        {
          align: 'center',
          text: 'Date filed',
          value: 'date_filed',
        },
      ],
    };
  },
  created() {},
  methods: {
    ...mapActions('service', ['serviceReportData', 'serviceReportListPdf']),
    async generate() {
      const payload = {
        startDate: this.dates[0],
        endDate: this.dates[1],
      };
      this.serviceReportData(payload);
    },
    getStatusColor(status) {
      if (status === 'Pending') return 'warning';
      if (status === 'Served') return 'success';
      if (status === 'Fulfilled') return 'primary';
      return null;
    },
    spliceString(text) {
      return utils.spliceLongString(text, 30);
    },
    excelExport() {
      const payload = {
        startDate: this.dates[0],
        endDate: this.dates[1],
      };
      this.serviceReportListPdf(payload);
    //   const data = [
    //     {
    //       sheet: 'Services',
    //       columns: [
    //         { label: 'Status', value: 'request_status' }, // Top level data
    //         { label: 'Office', value: 'office.office' },
    //         {
    //           label: 'Request By',
    //           value: row => `${row.request_by.first_name}  ${row.request_by.last_name}`,
    //         },
    //         // { label: 'Borrower First Name', value: 'borrower.first_name' },
    //         { label: 'Details', value: 'reason' },
    //         { label: 'Equipment.', value: 'equipment' },
    //         { label: 'Service Type.', value: 'service.service' },
    //         { label: 'Served By', value: row => row.served_by ? `${row.served_by.first_name}  ${row.served_by.last_name}` : '' },
    //         { label: 'Date filed.', value: 'date_filed' },
    //         { label: 'Date served.', value: 'date_served' },
    //         { label: 'Satisfaction', value: 'satisfaction' },
    //         { label: 'Remarks/Recommendations.', value: 'remarks' },
    //       ],
    //       content: this.reportData,
    //     },
    //   ];
    //   const settings = {
    //     fileName: `${this.dateRangeText}-service-report`,
    //   };
    //   xlsx(data, settings);
    },
  },
  computed: {
    ...mapState('service', ['reportData']),
    dateRangeText() {
      return this.dates.join(' ~ ');
    },
  },
};
</script>
