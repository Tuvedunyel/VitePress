import { resolve, sep } from 'node:path'

// find theme dir name
function getThemeDir() {
  const path = process.cwd().split(sep)
  return path[path.length - 1]
}

export default getThemeDir
