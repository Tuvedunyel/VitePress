const setColorScheme = (colorScheme: string) => {
  const body = document.body

  if (colorScheme === 'light') {
    body.classList.add('light')
  } else {
    body.classList.remove('light')
  }
}

export default setColorScheme
