import setColorScheme from '#components/colorScheme'

const prefersColorScheme = window.matchMedia('(prefers-color-scheme: dark)') ? 'dark' : 'light';
const themeButton = document.querySelector('#theme-handler') as HTMLButtonElement;
const themeSection = document.querySelector('.color-theme') as HTMLDivElement

setColorScheme(prefersColorScheme);
const icon = themeButton.querySelectorAll('span')

icon.forEach((i) => {
  if (!i.classList.contains("default")) {
    i.style.display = "none";
  } else {
    i.style.display = "inline";
  }
})
  const otherThemes = document.querySelector('.other-themes')

themeSection?.addEventListener('mouseover', () => {
  otherThemes?.classList.add('show');
})

themeSection?.addEventListener('mouseleave', () => {
  otherThemes?.classList.remove('show');
});

const otherThemeSelector: NodeListOf<HTMLLIElement> = document.querySelectorAll('.other-themes > li');

otherThemeSelector.forEach((theme) => {
  theme.addEventListener('click', () => {
    const icon = themeButton.querySelectorAll('span')

    icon.forEach((i) => {
      if (!i.classList.contains(theme.dataset.theme!)) {
        i.style.display = "none";
      } else {
        i.style.display = "inline";
      }
    })

    if (theme.dataset.theme === 'default') {
      setColorScheme(prefersColorScheme);
    } else {
      setColorScheme(theme.dataset.theme!);
    }
  })
})

// themeButton.addEventListener('click', () => {
//   const body = document.body;
//   const currentColorScheme = body.classList.contains('light') ? 'light' : 'dark';
//   const newColorScheme = currentColorScheme === 'light' ? 'dark' : 'light';
//
//   setColorScheme(newColorScheme);
// });
