class Lightbox {
  element: HTMLElement
  images: { url: string; title: string }[]
  touchStartX: number
  touchStartY: number
  url: string | null
  touchEndX: number
  touchEndY: number

  static init(el: HTMLElement) {
    const links: HTMLLinkElement[] = Array.from(
      el.querySelectorAll(
        "a[href$='.jpg'], a[href$='.jpeg'], a[href$='.png'], a[href$='.gif'], a[href$='.webp']"
      )
    )

    const gallery = links.map((link) => {

      return {
        url: link.getAttribute('href')!,
        title: link.getAttribute('title')!,
      }
    })

    links.forEach((link) => {
      link.addEventListener('click', (e: MouseEvent) => {
        e.preventDefault()
        const target = e.currentTarget as HTMLLinkElement
        const href = target.getAttribute('href')
        const title = target.getAttribute('title')
        if (href && title) {
          new Lightbox(href, title, gallery)
        }
      })
    })
  }

  constructor(url: string, title: string, gallery: { url: string; title: string }[]) {
    this.element = this.buildDOM()
    this.images = gallery
    this.url = url
    this.loadImage(url, title)
    this.touchStartX = 0
    this.touchStartY = 0
    this.touchEndX = 0
    this.touchEndY = 0
    document.body.appendChild(this.element)
    document.addEventListener('keyup', (e) => this.onKeyUp(e))
    document.addEventListener('touchstart', (e) => {
      this.touchStartX = e.changedTouches[0].clientX
      this.touchStartY = e.changedTouches[0].clientY
    })
    document.addEventListener('touchend', (e) => this.onTouchStart(e))
  }

  loadImage(url: string, title: string) {
    this.url = null
    const image = new Image()
    const container = this.element.querySelector('.lightbox__container')
    const loader = document.createElement('div')
    loader.classList.add('lightbox__loader')
    container!.innerHTML = ''
    container!.appendChild(loader)
    image.onload = () => {
      container!.removeChild(loader)
      container!.appendChild(image)
      this.url = url
    }
    image.src = url
    image.alt = title
  }

  close(e: Event) {
    e.preventDefault()
    document.body.style.overflow = 'auto'
    this.element.classList.add('fadeOut')
    window.setTimeout(() => {
      this.element.remove()
    }, 500)
    document.removeEventListener('keyup', (event) => this.onKeyUp(event))
    document.removeEventListener('touchstart', () => {
      this.touchStartX = 0
      this.touchStartY = 0
    })
    document.removeEventListener('touchend', (event) => this.onTouchStart(event))
  }

  onTouchStart(e: TouchEvent) {
    this.touchEndX = e.changedTouches[0].clientX
    this.touchEndY = e.changedTouches[0].clientY
    const swipeDistanceX = this.touchEndX - this.touchStartX
    const swipeDistanceY = this.touchEndY - this.touchStartY

    if (swipeDistanceY < -50) {
      this.close(e)
    }

    if (swipeDistanceX > 50) {
      this.prev(e)
    } else if (swipeDistanceX < -50) {
      this.next(e)
    }
  }

  onKeyUp(e: KeyboardEvent) {
    if (e.key === 'Escape') {
      this.close(e)
    }
    if (e.key === 'ArrowRight') {
      this.next(e)
    }
    if (e.key === 'ArrowLeft') {
      this.prev(e)
    }
  }

  next(e: Event) {
    e.preventDefault()
    const current = this.images.findIndex((img) => img.url === this.url)
    if (current === this.images.length - 1) {
      this.loadImage(this.images[0].url, this.images[0].title)
    } else {
      this.loadImage(this.images[current + 1].url, this.images[current + 1].title)
    }
  }

  prev(e: Event) {
    e.preventDefault()
    const current = this.images.findIndex((img) => img.url === this.url)
    if (current === 0) {
      this.loadImage(
        this.images[this.images.length - 1].url,
        this.images[this.images.length - 1].title
      )
    } else {
      this.loadImage(this.images[current - 1].url, this.images[current - 1].title)
    }
  }

  buildDOM(): HTMLDivElement {
    document.body.style.overflow = 'hidden'
    const dom = document.createElement('div')
    dom.classList.add('lightbox')
    dom.innerHTML = ` <div class="lightbox">
        <button class="lightbox__close"><span class="screen-reader-text">Fermer</span></button>
        <button class="lightbox__next"><span class="screen-reader-text">Suivant</span></button>
        <button class="lightbox__prev"><span class="screen-reader-text">Précédent</span></button>
        <div class="lightbox__container">
        </div>
    </div>`
    dom.querySelector('.lightbox__close')!.addEventListener('click', (e) => {
      this.close(e)
    })
    dom.querySelector('.lightbox__next')!.addEventListener('click', (e) => {
      this.next(e)
    })
    dom.querySelector('.lightbox__prev')!.addEventListener('click', (e) => {
      this.prev(e)
    })
    return dom
  }
}

export { Lightbox }
