<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="300">
      <v-card>
        <v-form ref="form" @submit.prevent="submit">
          <v-card-title class="text-h6">
            Forward
          </v-card-title>
          <v-col cols="12">
                <v-autocomplete
                  @change="filterUsers"
                  v-model="office_id"
                  label="Select Office"
                  :items="offices"
                  item-text="office"
                  item-value="id"
                  required
                  :rules="required"
                >
                </v-autocomplete>
          </v-col>
                <v-col cols="12">
                <v-autocomplete
                  v-model="approver_id"
                  label="Select user"
                  :items="filteredUsers"
                  :item-text="item => `${item.last_name}, ${item.first_name}`"
                  item-value="id"
                  required
                  :rules="required"
                >
                </v-autocomplete>
                </v-col>
          <!-- <v-card-text>
            <v-textarea v-model="rejection_remarks" outlined> </v-textarea>
          </v-card-text> -->
          <v-card-actions class="mx-auto">
            <v-spacer></v-spacer>
            <v-btn color="default darken-1" @click="$emit('close')">
              Cancel
            </v-btn>
            <v-btn color="success darken-1" type="submit">
              Forward
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'ForwardToApproverDialog',
  props: {
    dialog: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      approver_id: 0,
      office_id: 0,
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
  methods: {
    filterUsers() {
      const a = this.users.filter(x => {
        return x.office.id === this.office_id;
      });
      this.filteredUsers = a;
    },
    submit() {
        this.$refs.form.validate();
        this.$emit('submit', this.approver_id)
    }
  },
  computed: {
    ...mapState('office', ['offices']),
    ...mapState('user', ['users']),
  },
};
</script>
