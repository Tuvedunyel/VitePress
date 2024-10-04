// Lightbox
// import { Lightbox } from '#components/lightbox'

// Accordion
// import { Accordion } from '#components/accordion'

import setColorScheme from '#ts/components/color_scheme'

const prefersColorScheme = window.matchMedia('(prefers-color-scheme: dark)') ? 'dark' : 'light'
const themeButton = document.querySelector('#theme-handler') as HTMLButtonElement
const themeSection = document.querySelector('.color-theme') as HTMLDivElement
const icon = themeButton.querySelectorAll('span')

setColorScheme(prefersColorScheme)

icon.forEach((i) => {
  if (!i.classList.contains('default')) {
    i.style.display = 'none'
  } else {
    i.style.display = 'inline'
  }
})
const otherThemes = document.querySelector('.other-themes')

themeSection?.addEventListener('click', () => {
  otherThemes?.classList.toggle('show')
})

const otherThemeSelector: NodeListOf<HTMLLIElement> =
  document.querySelectorAll('.other-themes > li')

otherThemeSelector.forEach((theme) => {
  theme.addEventListener('click', () => {
    icon.forEach((i) => {
      if (!i.classList.contains(theme.dataset.theme!)) {
        i.style.display = 'none'
      } else {
        i.style.display = 'inline'
      }
    })

    if (theme.dataset.theme === 'default') {
      setColorScheme(prefersColorScheme)
    } else {
      setColorScheme(theme.dataset.theme!)
    }
  })
})
