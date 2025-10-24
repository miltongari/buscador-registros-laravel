<template>
  <div class="col">
    <label class="cyber-label">Buscar empresas</label>
    <div class="input-wrapper">
      <input
        class="cyber-input"
        type="text"
        :value="modelValue"
        @input="onInput"
        @keyup.enter="emitSearch"
        placeholder="Ej: Comercio, Tecnología, Agricultura..."
      />
      <span v-if="loading" class="spinner"></span>
    </div>

    <div class="row" style="justify-content: flex-end; gap: .5rem; margin-top: 1rem;">
      <button class="cyber-button ghost" @click="clear" :disabled="loading">
        Limpiar
      </button>
      <button class="cyber-button primary" @click="emitSearch" :disabled="loading">
        <template v-if="loading">
          <span class="btn-spinner"></span> Buscando...
        </template>
        <template v-else>
          Buscar
        </template>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SearchBar',
  props: {
    modelValue: { type: String, default: '' },
    loading: { type: Boolean, default: false }
  },
  emits: ['update:modelValue', 'search', 'live'],
  methods: {
    onInput(e) {
      const val = e.target.value
      this.$emit('update:modelValue', val)
      this.$emit('live', val)
    },
    
    emitSearch() {
      this.$emit('search')
    },
    
    clear() {
      this.$emit('update:modelValue', '')
      this.$emit('live', '')
    }
  }
}
</script>

<style scoped>
.input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.spinner {
  position: absolute;
  right: 1rem;
  width: 1rem;
  height: 1rem;
  border: 2px solid var(--text-muted);
  border-top-color: var(--accent);
  border-radius: 50%;
  animation: spin 0.6s linear infinite;
}

.btn-spinner {
  display: inline-block;
  width: 1rem;
  height: 1rem;
  margin-right: 0.5rem;
  border: 2px solid #fff;
  border-top-color: transparent;
  border-radius: 50%;
  animation: spin 0.6s linear infinite;
  vertical-align: middle;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.cyber-button.ghost {
  background: transparent;
  border-color: var(--border);
}

.cyber-button.primary {
  background: var(--accent);
  color: var(--bg-primary);
  border-color: var(--accent);
}
</style>