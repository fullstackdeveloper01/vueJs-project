import { breakpointsVuetify } from '@vueuse/core'

import { VIcon } from 'vuetify/components'

// ❗ Logo SVG must be imported with ?raw suffix
import { defineThemeConfig } from '@core'
import { RouteTransitions, Skins } from '@core/enums'
import enforcementlogo from '@images/enforcement-logo.svg?raw'
import logo from '@images/logo.svg?raw'
import { AppContentLayoutNav, ContentWidth, FooterType, NavbarType } from '@layouts/enums'

export const { themeConfig, layoutConfig } = defineThemeConfig({
  app: {
    title: 'Enforcement Pro',

    // ❗ if you have SVG logo and want it to adapt according to theme color, you have to apply color as `color: rgb(var(--v-global-theme-primary))`
    logo: h('div', { innerHTML: logo, style: 'line-height:0; color: rgb(var(--v-global-theme-primary))' }),
    enforcementlogo: h('div', { innerHTML: enforcementlogo, style: 'line-height:0; color: rgb(var(--v-global-theme-primary))' }),
    contentWidth: ContentWidth.Boxed,
    contentLayoutNav: AppContentLayoutNav.Vertical,
    overlayNavFromBreakpoint: breakpointsVuetify.md + 16, // 16 for scrollbar. Docs: https://next.vuetifyjs.com/en/features/display-and-platform/
    enableI18n: true,
    theme: 'system',
    isRtl: false,
    skin: Skins.Default,
    routeTransition: RouteTransitions.Fade,
    iconRenderer: VIcon,
  },
  navbar: {
    type: NavbarType.Sticky,
    navbarBlur: true,
  },
  footer: { type: FooterType.Static },
  verticalNav: {
    isVerticalNavCollapsed: false,
    defaultNavItemIconProps: { icon: 'mdi-circle' },
    isVerticalNavSemiDark: true,
  },
  horizontalNav: {
    type: 'sticky',
    transition: 'slide-y-reverse-transition',
  },
  icons: {
    chevronDown: { icon: 'mdi-chevron-down' },
    chevronRight: { icon: 'mdi-chevron-right' },
    close: { icon: 'mdi-close' },
    verticalNavPinned: { icon: 'custom-vertical-nav-header-arrow', size: 22 },
    verticalNavUnPinned: { icon: 'custom-vertical-nav-header-arrow', size: 22 },
    sectionTitlePlaceholder: { icon: 'mdi-minus' },
  },
})
