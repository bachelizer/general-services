<template>
  <div>
    <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px" transition="dialog-top-transition">
      <v-card>
        <v-form ref="form" @submit.prevent="handleSubmit">
          <v-card-title>
            <span class="text-h5">Borrow Request Form</span>
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="6">
                <v-autocomplete
                  @change="filterUsers"
                  :readonly="disableField"
                  v-model="data.office_id"
                  label="Select Office"
                  :items="offices"
                  item-text="office"
                  item-value="id"
                  required
                  :rules="required"
                >
                </v-autocomplete>
              </v-col>
              <v-col cols="6">
                <v-autocomplete
                  @change="filterEquipment"
                  :readonly="disableField"
                  label="M.R from"
                  v-model="data.mr_id"
                  required
                  :items="filteredUsers"
                  :item-text="item => `${item.last_name}, ${item.first_name}`"
                  item-value="id"
                  :rules="required"
                >
                </v-autocomplete>
              </v-col>

              <v-col cols="6">
                <v-autocomplete
                  :readonly="disableField"
                  label="Equipment"
                  v-model="data.equipment_id"
                  required
                  :items="userEquipment"
                  item-text="code"
                  item-value="id"
                  :rules="required"
                >
                </v-autocomplete>
              </v-col>

              <v-col cols="6">
                <v-text-field
                  :readonly="disableField"
                  label="Quantity"
                  v-model.number="data.qty"
                  required
                  :rules="validateNumber"
                >
                </v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col>
                <v-textarea
                  :readonly="disableField"
                  label="Purpose"
                  v-model="data.purpose"
                  required
                  :rules="required"
                >
                </v-textarea>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="6">
                <v-menu
                  v-model="picker"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="data.promise_return_date"
                      label="Promise return date"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      required
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="data.promise_return_date"
                    @input="picker = false"
                  ></v-date-picker>
                </v-menu>
              </v-col>
            </v-row>
            <v-row>
              <v-col v-if="data.approval_status === 'Rejected'">
                <v-textarea
                  rules="Required"
                  required
                  :readonly="disableField"
                  label="Rejection Remarks"
                  v-model="data.rejection_remarks"
                >
                </v-textarea>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn type="reset" color="default darken-1" text @click="close">
              Close
            </v-btn>
            <v-btn v-if="action === 'create'" color="primary darken-1" text type="submit">
              Submit Request
            </v-btn>
            <!-- <div v-if="data.approval_status === 'Forwarded'">
              <v-btn @click="rejectDialog" color="error darken-1" text>
                Reject
              </v-btn>
              <v-btn
                v-if="isOP && action === 'consent'"
                @click="approve"
                color="success darken-1"
                text
              >
                Approve
              </v-btn>
            </div> -->
            <div v-if="data.approval_status === 'Pending' && isAdmin">
              <v-btn @click="approverDialog = true" color="success darken-1" text>
                forward to
              </v-btn>
            </div>

            <v-btn
              v-if="
                data.approval_status === 'Rejected' ||
                  data.approval_status === 'Approved' ||
                  data.approval_status === 'Returned'
              "
              color="success darken-1"
              text
              type="submit"
            >
              print
            </v-btn>
            <v-btn
              v-if="data.approval_status === 'Approved'"
              color="primary darken-1"
              text
              @click="returned"
            >
              Returned
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
    <rejection-dialog
      :dialog="rejectionDialog"
      @close="rejectionDialog = false"
      @submit="reject"
    ></rejection-dialog>
  </v-row>
  <forward-to-approver-dialog
  :dialog="approverDialog"
  @close="approverDialog = false"
  @submit="forwardToApprover">
  </forward-to-approver-dialog>
  </div>

  
</template>
<script>
import { mapActions, mapState } from 'vuex';
import RejectionDialog from '@/components/dialogs/RejectionDialog.vue';
import ForwardToApproverDialog from '@/components/dialogs/ForwardToApproverDialog.vue';

export default {
  components: { RejectionDialog, ForwardToApproverDialog },
  name: 'BorrowForm',
  props: {
    action: {
      type: String,
      default: '',
    },
    status: {
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
      // date: new Date().toISOString().substr(0, 10),
      office_id: 0,
      picker: false,
      rejectionDialog: false,
      approverDialog: false,
      required: [
        v => !!v || 'this field is required',
        // v => (v && v.length <= 10) || 'Name must be less than 10 characters',
      ],
      validateNumber: [
        v => !!v || 'this field is required',
        v => /[0-9]/.test(v) || 'Quantity must be number',
      ],
      filteredUsers: [],
    };
  },
  mounted() {},
  async created() {
    await this.onLoad();
    await this.$store.dispatch('equipment/fetchOfficeEquipment');
  },
  methods: {
    ...mapActions('borrow', [
      'postBorrows',
      'approveBorrow',
      'forwardBorrow',
      'rejectBorrow',
      'returnBorrow',
      'printForm',
    ]),
    ...mapActions('office', ['fetchOffice']),
    ...mapActions('user', ['fetchUsers', 'fetchUserEquipments']),
    reload() {
      this.$emit('reload');
    },
    async onLoad() {
      await this.fetchOffice();
      await this.fetchUsers();
      await this.filterUsers();
      this.filterEquipment();
    },
    filterUsers() {
      const a = this.users.filter(x => {
        return x.office.id === this.data.office_id;
      });
      this.filteredUsers = a;
    },
    filterEquipment() {
      this.fetchUserEquipments(this.data.mr_id);
    },
    async close() {
      this.$refs.form.resetValidation();
      this.$emit('close');
    },
    async handleSubmit() {
      this.$refs.form.validate();
      try {
        if (this.action === 'create') {
          const payload = {
            borrower_id: this.userCredential.data.user_id,
            borrower_office_id: this.userCredential.data.office_id,
            ...this.data,
          };
          await this.postBorrows(payload);
          this.reload();
        } else {
          this.printForm(this.data);
        }
        this.close();
      } catch (error) {
        alert(error);
      }
    },
    async rejectDialog() {
      this.rejectionDialog = true;
    },
    async reject(remarks) {
      try {
        const payload = {
          rejection_remarks: remarks,
          approver_id: this.userCredential.data.user_id, // take the user_id from the state
        };
        await this.rejectBorrow([payload, this.data.id]);
        this.rejectionDialog = false;
        this.reload();
        this.$emit('close');
      } catch (e) {
        alert(e.message);
      }
    },
    // forward to OP
    async forwardToApprover(approverId) {
      try {
        const payload = {
          approver_id: approverId, // take the user_id from the state
        };
        await this.forwardBorrow([payload, this.data.id]);
        
        this.reload();
        this.$emit('close');
      } catch (e) {
        alert(e.message);
      }
      // console.log(approverId);
    },
    async approve() {
      try {
        const payload = {
          approver_id: this.userCredential.data.user_id, // take the user_id from the state
        };
        await this.approveBorrow([payload, this.data.id]);
        this.reload();
        this.$emit('close');
      } catch (e) {
        alert(e.message);
      }
    },
    async returned() {
      try {
        await this.returnBorrow(this.data.id);
        this.reload();
        this.$emit('close');
      } catch (e) {
        alert(e.message);
      }
    },
  },
  computed: {
    ...mapState('equipment', ['officeEquipments']),
    ...mapState('auth', ['userCredential']),
    ...mapState('office', ['offices']),
    ...mapState('user', ['users', 'userEquipment']),
    generalServicesEquipments() {
      return this.officeEquipments.filter(x => x.office_id === 1);
    },
    disableField() {
      return this.action !== 'create';
    },
    isAdmin() {
      return this.userCredential.data.role_id !== 3;
    },
    isOP() {
      return this.userCredential.data.office_id === 3 && this.userCredential.data.role_id !== 3;
    },
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
