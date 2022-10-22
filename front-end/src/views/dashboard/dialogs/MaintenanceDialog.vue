<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="500">
      <v-card>
        <v-form @submit.prevent="$emit('submit', data)">
          <v-card-title class="text-h6">
            Maintenance Action
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="12">
                <v-textarea v-model="params.action_taken" outlined label="Action taken">
                </v-textarea>
              </v-col>
              <v-col cols="12">
                <v-select
                  :items="maintener"
                  v-model="params.maintainedBy"
                  :item-text="x => `${x.last_name}, ${x.first_name}`"
                  item-value="id"
                  label="Maintained by"
                  required
                ></v-select>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions class="mx-auto">
            <v-spacer></v-spacer>
            <v-btn
              color="default darken-1"
              @click="$emit('close'), (maintainedBy = null), (action_taken = '')"
              type="reset"
            >
              Cancel
            </v-btn>
            <v-btn color="primary darken-1" type="submit">
              Submit
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import { mapState, mapActions } from 'vuex';

export default {
  props: {
    dialog: {
      type: Boolean,
      default: false,
    },
    maintenanceData: {
      type: Object,
    },
  },
  data() {
    return {
      params: {
        action_taken: '',
        maintainedBy: Number,
      },
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
  },
  computed: {
    ...mapState('user', ['users']),
    maintener() {
      return this.users.filter(x => x.office.id === 1);
    },
    data() {
      return { ...this.maintenanceData, ...this.params };
    },
  },
};
</script>
