<template>
  <v-navigation-drawer
    :value="isDrawerOpen"
    app
    floating
    width="260"
    class="app-navigation-menu"
    :right="$vuetify.rtl"
    @input="val => $emit('update:is-drawer-open', val)"
  >
    <!-- Navigation Header -->
    <div class="vertical-nav-header d-flex items-center ps-6 pe-5 pt-5 pb-2">
      <router-link to="/" class="d-flex align-center text-decoration-none">
        <v-img
          :src="require('@/assets/images/logos/logo.png')"
          max-height="30px"
          max-width="30px"
          alt="logo"
          contain
          eager
          class="app-logo me-3"
        ></v-img>
        <v-slide-x-transition>
          <h2 class="app-title text--primary">
            G-S-S
          </h2>
        </v-slide-x-transition>
      </router-link>
    </div>

    <!-- Navigation Items -->
    <v-list expand shaped class="vertical-nav-menu-items pr-5">
      <nav-menu-link
        title="Dashboard"
        :to="{ name: 'dashboard' }"
        :icon="icons.mdiHomeOutline"
      ></nav-menu-link>
      <nav-menu-link
        title="Service"
        :to="{ name: 'service' }"
        :icon="icons.mdiCogs"
      ></nav-menu-link>
      <nav-menu-link
        title="Borrow"
        :to="{ name: 'borrow' }"
        :icon="icons.mdiSwapHorizontal"
      ></nav-menu-link>
      <div v-if="isAdmin">
        <nav-menu-section-title title="USER INTERFACE"></nav-menu-section-title>
        <nav-menu-group title="Reports" :icon="icons.mdiFileOutline">
          <nav-menu-link title="Service Report" :to="{ name: 'service-report' }"> </nav-menu-link>
          <nav-menu-link title="Borrow Report" :to="{ name: 'borrow-report' }"></nav-menu-link>
          <!-- <nav-menu-link title="Equipment Report"></nav-menu-link> -->
        </nav-menu-group>
        <nav-menu-group title="Utilities" :icon="icons.mdiFileOutline">
          <nav-menu-link title="Users" :to="{ name: 'users' }"> </nav-menu-link>
          <nav-menu-link title="Equipments" :to="{ name: 'equipment' }"></nav-menu-link>
          <nav-menu-link title="Offices" :to="{ name: 'office' }"></nav-menu-link>
        </nav-menu-group>
        <nav-menu-link
        title="Inventory"
        :to="{ name: 'inventory' }"
        :icon="icons.mdiFormatPaint "
      ></nav-menu-link>
      </div>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import { mapState } from 'vuex';

import {
  mdiHomeOutline,
  mdiAlphaTBoxOutline,
  mdiEyeOutline,
  mdiCreditCardOutline,
  mdiTable,
  mdiFileOutline,
  mdiFormSelect,
  mdiAccountCogOutline,
  mdiCogs,
  mdiSwapHorizontal,
  mdiFormatPaint 
} from '@mdi/js';
import NavMenuSectionTitle from './components/NavMenuSectionTitle.vue';
import NavMenuGroup from './components/NavMenuGroup.vue';
import NavMenuLink from './components/NavMenuLink.vue';

export default {
  components: {
    NavMenuSectionTitle,
    NavMenuGroup,
    NavMenuLink,
  },
  props: {
    isDrawerOpen: {
      type: Boolean,
      default: null,
    },
  },
  setup() {
    return {
      icons: {
        mdiCogs,
        mdiHomeOutline,
        mdiAlphaTBoxOutline,
        mdiEyeOutline,
        mdiCreditCardOutline,
        mdiTable,
        mdiFileOutline,
        mdiFormSelect,
        mdiAccountCogOutline,
        mdiSwapHorizontal,
        mdiFormatPaint,
      },
    };
  },
  computed: {
    ...mapState('auth', ['userCredential']),
    isAdmin() {
      return this.userCredential.data.office_id !== 3;
    },
  },
};
</script>

<style lang="scss" scoped>
.app-title {
  font-size: 1.25rem;
  font-weight: 700;
  font-stretch: normal;
  font-style: normal;
  line-height: normal;
  letter-spacing: 0.3px;
}

// ? Adjust this `translateX` value to keep logo in center when vertical nav menu is collapsed (Value depends on your logo)
.app-logo {
  transition: all 0.18s ease-in-out;
  .v-navigation-drawer--mini-variant & {
    transform: translateX(-4px);
  }
}

@include theme(app-navigation-menu) using ($material) {
  background-color: map-deep-get($material, 'background');
}

.app-navigation-menu {
  .v-list-item {
    &.vertical-nav-menu-link {
      ::v-deep .v-list-item__icon {
        .v-icon {
          transition: none !important;
        }
      }
    }
  }
}

// You can remove below style
// Upgrade Banner
.app-navigation-menu {
  .upgrade-banner {
    position: absolute;
    bottom: 13px;
    left: 50%;
    transform: translateX(-50%);
  }
}
</style>
