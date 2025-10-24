// debounce.js
export default function debounce(fn, delay = 300) {
  let t = null
  
  const debounced = function (...args) {
    const context = this
    clearTimeout(t)
    t = setTimeout(() => fn.apply(context, args), delay)
  }
  
  // Agregar método para cancelar el timeout
  debounced.cancel = function() {
    clearTimeout(t)
    t = null
  }
  
  return debounced
}