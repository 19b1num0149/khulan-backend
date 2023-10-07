import { createI18n } from 'vue-i18n'

import login  from './login'
import form  from './form'
import sidebar  from './sidebar'
import settings  from './settings'
import shared  from './shared'
import navbar  from './navbar'
import hr  from './hr'
import temple from './temple'
import group from './group'

const i18n = createI18n({

  // default locale
  locale: 'mn',

  // translations
  messages: {
    mn: {
      ...login,
      ...form,
      ...sidebar,
      ...settings,
      ...shared,
      ...navbar,
      ...hr,
      ...temple,
      ...group
    }

  },

})



export default i18n