<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <PageTitle :title="'Users'" :subTitle="'Panel for users.'" />
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
        <v-data-table :headers="headers" :items="users" :search="search">
          <template v-slot:item.actions="{ item }">
            <v-btn small @click="view(item)" color="success"> View </v-btn>
          </template>
        </v-data-table>
      </v-card>
      <users-form
        v-if="dialog"
        :data="user"
        :dialog="dialog"
        :action="action"
        @close="dialog = false, action = ''"
        @reload="onload"
      ></users-form>
    </v-col>
  </v-row>
</template>
<script>
import { mapState, mapActions } from 'vuex';
import { mdiPlus } from '@mdi/js';
import PageTitle from '@/components/PageTitle.vue';
import UsersForm from './UsersForm.vue';

export default {
  components: { PageTitle, UsersForm },
  name: 'Borrow',
  data() {
    return {
      action: '',
      dialog: false,
      user: {},
      icons: {
        mdiPlus,
      },
      search: '',
      headers: [
        {
          text: 'Designation',
          value: 'designation',
          sortable: true,
        },
        { text: 'Lastname', value: 'last_name' },
        { text: 'Firstname', value: 'first_name' },
        { text: 'Middlename', value: 'middle_name' },
        {
          text: 'Suffix',
          value: 'suffix',
        },
        {
          text: 'Office',
          value: 'office.office',
        },
        {
          text: 'Role',
          value: 'role.role',
        },
        {
          text: 'Action',
          value: 'actions',
        },
      ],
    };
  },
  created() {
    this.onload();
  },
  methods: {
    ...mapActions('user', ['fetchUsers']),
    onload() {
      this.fetchUsers();
    },
    view(data) {
      this.user = data;
      this.dialog = true;
    },
  },
  computed: {
    ...mapState('user', ['users']),
  },
};
</script>
