<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <PageTitle :title="'3rd Party Services'" :subTitle="'Panel for third party services.'" />
        <v-col>
          <v-row>
            <v-col cols="8" md="5">
              <v-text-field
                v-model="search"
                outlined
                dense
                placeholder="Search user"
                hide-details
              ></v-text-field>
            </v-col>
            <v-spacer></v-spacer>
            <v-btn elevation="2" small class="mr-10 mt-2" fab color="primary">
              <v-icon @click="(dialog = true), (action = 'create')">
                <!-- <v-icon> -->
                {{ icons.mdiPlus }}
              </v-icon>
            </v-btn>
          </v-row>
        </v-col>
        <v-data-table :headers="headers" :items="outSources" :search="search">
          <template v-slot:item.actions="{ item }">
            <v-btn small @click="view(item)" color="success"> View </v-btn>
          </template>
        </v-data-table>
      </v-card>
      <third-party-form
        v-if="dialog"
        :data="outsoure"
        :dialog="dialog"
        :action="action"
        @submit="handleFormSubmit"
        @close="(dialog = false), (action = '')"
      >
      </third-party-form>
      <!-- <users-form
          v-if="dialog"
          :data="user"
          :dialog="dialog"
          :action="action"
          @close="dialog = false, action = ''"
        ></users-form> -->
    </v-col>
  </v-row>
</template>
<script>
import { mapActions, mapState } from 'vuex';
import { mdiPlus } from '@mdi/js';

import PageTitle from '@/components/PageTitle.vue';
import ThirdPartyForm from './ThirdPartyForm.vue';

export default {
  components: { PageTitle, ThirdPartyForm },
  name: 'ThirdParty',
  data() {
    return {
      outsoure: {},
      action: '',
      dialog: false,
      user: {},
      icons: {
        mdiPlus,
      },
      search: '',
      headers: [
        {
          text: 'Establishment',
          value: 'institution_name',
          sortable: true,
        },
        {
          text: 'Owner',
          value: 'owner',
          sortable: false,
        },
        // {
        //   text: 'Action',
        //   value: 'actions',
        // },
      ],
    };
  },
  created() {
    this.onLoad();
  },
  methods: {
    ...mapActions('outsource', ['createOutsource', 'fetchOutSources']),
    onLoad() {
      this.fetchOutSources();
    },
    async handleFormSubmit(payload) {
      try {
        await this.createOutsource(payload);
        this.onLoad();
        this.dialog = false;
      } catch (error) {
        alert(error.message);
      }
    },
  },
  computed: {
    ...mapState('outsource', ['outSources']),
  },
};
</script>
