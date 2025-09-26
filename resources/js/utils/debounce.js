export default function debounce(fn, delay = 300) {
  let t = null
  return function (...args) {
    const context = this
    clearTimeout(t)
    t = setTimeout(() => fn.apply(context, args), delay)
  }
}