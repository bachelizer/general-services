<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <PageTitle :title="'Office'" :subTitle="'Panel for offices.'" />
        <v-col>
          <v-row>
            <v-col cols="8" md="5">
              <v-text-field
                v-model="search"
                outlined
                dense
                placeholder="Search office"
                hide-details
              ></v-text-field>
            </v-col>
            <v-spacer></v-spacer>
            <v-btn elevation="2" small class="mr-10 mt-2" fab color="primary">
              <v-icon @click="officeDialog = true">
                {{ icons.mdiPlus }}
              </v-icon>
            </v-btn>
          </v-row>
        </v-col>
        <v-data-table :headers="headers" :items="offices" :search="search"> </v-data-table>
      </v-card>
      <office-form
        :dialog="officeDialog"
        @submit="handleSubmit"
        @close="officeDialog = false"
      ></office-form>
    </v-col>
  </v-row>
</template>
<script>
import { mapActions, mapState } from 'vuex';
import { mdiPlus } from '@mdi/js';
import PageTitle from '@/components/PageTitle.vue';
import OfficeForm from './OfficeForm.vue';

export default {
  components: { PageTitle, OfficeForm },
  name: 'Office',
  data() {
    return {
      officeDialog: false,
      icons: {
        mdiPlus,
      },
      search: '',
      headers: [
        {
          text: 'Office',
          value: 'office',
          sortable: true,
        },
      ],
    };
  },
  created() {
    this.$store.dispatch('office/fetchOffice');
  },
  methods: {
    ...mapActions('office', ['createOffice']),
    async handleSubmit(office) {
      const obj = {
        office,
      };
      await this.createOffice(obj);
      this.$store.dispatch('office/fetchOffice');
      this.officeDialog = false;
    },
  },
  computed: {
    ...mapState('office', ['offices']),
  },
};
</script>
