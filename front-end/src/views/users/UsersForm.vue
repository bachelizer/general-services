<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px" transition="dialog-top-transition">
      <v-card>
        <v-form ref="form" v-model="valid" lazy-validation @submit.prevent="handleSubmit(data)">
          <v-card-title>
            <span class="text-h5">Users Form</span>
            <v-spacer></v-spacer>
            <v-btn
              v-if="data.account === null"
              color="error darken-1"
              @click="userAccountDialog = true"
              small
              tile
            >
              Create Account
            </v-btn>
            <!-- <v-btn color="error darken-1" class="ml-2" small tile>
              Edit
            </v-btn> -->
          </v-card-title>
          <v-card-text>
            <v-row v-if="data.account">
              <v-col>
                <i
                  ><span style="color: red">username:</span>
                  <strong>{{ data.account.username }}</strong></i
                >
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="4">
                <v-text-field :rules="requiredRules" required v-model="data.designation" label="Designation"></v-text-field>
              </v-col>
              <v-col cols="4">
                <v-select
                :rules="requiredRules"
                  v-model="data.role_id"
                  label="Role"
                  :items="roles"
                  item-text="role"
                  item-value="id"
                ></v-select>
              </v-col>
            </v-row>
            <v-row>
              <v-col col>
                <v-text-field
                required
                  :rules="requiredRules"
                  v-model="data.last_name"
                  label="Last Name"
                ></v-text-field>
              </v-col>
              <v-col col>
                <v-text-field  :rules="requiredRules" required v-model="data.first_name" label="First Name"></v-text-field>
              </v-col>
              <v-col col>
                <v-text-field
                required
                :rules="requiredRules"
                  v-model="data.middle_name"
                  label="Middle Name"
                ></v-text-field>
              </v-col>
              <v-col cols="2">
                <v-text-field required v-model="data.suffix" label="Suffix"></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="8">
                <v-autocomplete
                required
                :rules="requiredRules"
                  v-model="data.office_id"
                  :items="offices"
                  item-value="id"
                  item-text="office"
                  label="Office"
                ></v-autocomplete>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn type="reset" color="default darken-1" text @click="$emit('close')">
              Close
            </v-btn>
            <v-btn :disabled="!valid" v-if="action === 'create'" color="primary darken-1" text type="submit">
              Create
            </v-btn>
            <v-btn v-if="action !== 'create'" color="primary darken-1" text @click="update">
              Save
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
    <users-account
      v-if="userAccountDialog"
      :dialog="userAccountDialog"
      @close="userAccountDialog = false"
      @submit="storeAccount"
    ></users-account>
  </v-row>
</template>
<script>
import { mapActions, mapState } from 'vuex';
import UsersAccount from './UsersAccount.vue';

export default {
  components: { UsersAccount },
  name: 'UsersForm',
  props: {
    action: {
      type: String,
      default: '',
    },
    dialog: {
      type: Boolean,
      default: false,
    },
    data: {
      type: Object,
      default: Object,
    },
  },
  data() {
    return {
      valid: true,
      userAccountDialog: false,
      requiredRules: [v => !!v || 'This field is required'],
    };
  },
  created() {
    this.$store.dispatch('office/fetchOffice');
    this.$store.dispatch('role/fetchRole');
  },
  methods: {
    ...mapActions('user', ['createUsers', 'updateUser']),
    ...mapActions('account', ['createAccount']),
    async handleSubmit() {
      await this.$refs.form.validate();
      if (this.action === 'create') {
        await this.createUsers(this.data);
      }
      this.dialog = false;
    },
    async storeAccount(data) {
      this.userAccountDialog = false;
      const payload = { ...data, user_id: this.data.id };
      await this.createAccount(payload);
    },
    async update() {
      await this.updateUser([this.data.id, this.data]);
      this.$emit('close');
    },
  },
  computed: {
    ...mapState('office', ['offices']),
    ...mapState('role', ['roles']),
  },
};
</script>
<style scoped>
.small-radio {
  font-size: 12px;
}
.small-radio label {
  font-size: 10px;
  padding-left: 0px;
  margin-left: -4px;
}
.small-radio .v-radio {
  padding: 0px;
}
.small-radio [class*='__ripple'] {
  left: 0;
}
.size {
  font-size: 10px;
}
</style>
