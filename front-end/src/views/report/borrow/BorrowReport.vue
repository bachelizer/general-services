<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <PageTitle :title="'Borrow Report'" :subTitle="'Panel for borrow report.'" />
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
            <v-btn @click="pdfExport" class="mt-2" color="primary darken-1" tile>
              Download Data
            </v-btn>
          </v-row>
        </v-col>

        <v-data-table :headers="headers" :items="reportData">
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
  name: 'BorrowReport',
  data() {
    return {
      datePckr: false,
      dates: [],
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
          text: 'Date Borrowed',
          value: 'date_borrowed',
        },
      ],
    };
  },
  created() {},
  methods: {
    ...mapActions('borrow', ['borrowReportData', 'borrowReportListPdf']),
    async generate() {
      const payload = {
        startDate: this.dates[0],
        endDate: this.dates[1],
      };
      this.borrowReportData(payload);
    },
    getStatusColor(status) {
      if (status === 'Pending') return 'warning';
      if (status === 'Approved') return 'success';
      if (status === 'Rejected') return 'error';
      if (status === 'Returned') return 'primary';
      return null;
    },
    spliceString(text) {
      return utils.spliceLongString(text, 30);
    },
    pdfExport() {
      const payload = {
        startDate: this.dates[0],
        endDate: this.dates[1],
      };
      this.borrowReportListPdf(payload);
      // const data = [
      //   {
      //     sheet: 'Borrow',
      //     columns: [
      //       { label: 'Approval Status', value: 'approval_status' }, // Top level data
      //       { label: 'Office', value: 'office.office' },
      //       { label: 'Borrower Name', value: (row) => `${row.borrower.first_name}  ${row.borrower.last_name}` },
      //       // { label: 'Borrower First Name', value: 'borrower.first_name' },
      //       { label: 'Equipment', value: 'equipment.code' },
      //       { label: 'Qty.', value: 'qty' },
      //       { label: 'Purpose.', value: 'purpose' },
      //       { label: 'Rejection Remarks.', value: 'rejection_remarks' },
      //       { label: 'Date Borrowed.', value: 'date_borrowed' },
      //     ],
      //     content: this.reportData,
      //   },
      // ];
      // const settings = {
      //   fileName:  `${this.dateRangeText}-borrow-report`,
      // };
      // xlsx(data, settings);
    },
  },
  computed: {
    ...mapState('borrow', ['reportData']),
    dateRangeText() {
      return this.dates.join(' ~ ');
    },
  },
};
</script>
